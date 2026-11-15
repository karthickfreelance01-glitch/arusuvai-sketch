<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Stripe Checkout for the 30-day meal plans.
 *
 * Uses Stripe's REST API directly through Laravel's HTTP client, so no extra
 * composer package is needed. Add these to .env:
 *
 *   STRIPE_KEY=pk_test_...
 *   STRIPE_SECRET=sk_test_...
 *
 * Without a secret key the sketch runs in "demo mode" and goes straight to
 * the success page, so the client can still click through the whole flow.
 */
class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $plans     = config('arusuvai.plans');
        $schedules = config('arusuvai.schedules');

        $data = $request->validate([
            'plan'       => 'required|in:' . implode(',', array_keys($plans)),
            'schedule'   => 'required|in:' . implode(',', array_keys($schedules)),
            'meals'      => 'nullable|array',
            'cuisine'    => 'nullable|string|max:40',
            'start_date' => 'required|date|after_or_equal:today',
            'name'       => 'required|string|max:120',
            'phone'      => 'required|string|max:30',
            'email'      => 'nullable|email|max:150',
            'whatsapp'   => 'nullable|string|max:30',
            'room_no'    => 'nullable|string|max:60',
            'building'   => 'required|string|max:150',
            'area'       => 'nullable|string|max:150',
            'notes'      => 'nullable|string|max:500',
            'pay_method' => 'required|in:stripe,cash',
            'coupon'     => 'nullable|string|max:30',
        ]);

        $plan = $plans[$data['plan']];

        // Price is decided on the server, never trusted from the browser.
        if (! isset($plan['prices'][$data['schedule']])) {
            return back()->withErrors(['schedule' => __('This plan is not available for the selected days.')])->withInput();
        }
        $amount   = $plan['prices'][$data['schedule']];
        $code     = strtoupper(trim($data['coupon'] ?? ''));
        $coupon   = config('arusuvai.coupons')[$code] ?? null;
        $discount = ! $coupon ? 0 : ($coupon['type'] === 'percent' ? round($amount * $coupon['value'] / 100) : min($amount, $coupon['value']));
        $total    = $amount - $discount;

        $summary = [
            'plan'      => $plan['name'],
            'schedule'  => $schedules[$data['schedule']]['label'],
            'meals'     => implode(', ', array_map('ucfirst', $data['meals'] ?? [])),
            'start'     => $data['start_date'],
            'name'      => $data['name'],
            'amount'    => $amount,
            'discount'  => $discount,
            'coupon'    => $coupon ? $code : null,
            'total'     => $total,
            'method'    => $data['pay_method'],
            'reference' => 'ARU-' . strtoupper(substr(md5(uniqid('', true)), 0, 8)),
        ];
        session(['booking' => $summary]);

        if ($data['pay_method'] === 'cash') {
            return redirect()->route('payment.success', ['mode' => 'cash']);
        }

        $secret = config('arusuvai.stripe.secret');
        if (! $secret) {
            return redirect()->route('payment.success', ['mode' => 'demo']);
        }

        $payload = [
            'mode'                 => 'payment',
            'success_url'          => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => route('payment.cancel'),
            'client_reference_id'  => $summary['reference'],
            'billing_address_collection' => 'auto',
            'line_items' => [[
                'quantity'   => 1,
                'price_data' => [
                    'currency'     => config('arusuvai.stripe.currency'),
                    'unit_amount'  => (int) round($total * 100),
                    'product_data' => [
                        'name'        => 'Arusuvai Mess – ' . $plan['name'] . ' (30 days)',
                        'description' => $summary['schedule'] . ' · starts ' . $summary['start'],
                    ],
                ],
            ]],
            'metadata' => [
                'reference' => $summary['reference'],
                'plan'      => $data['plan'],
                'schedule'  => $data['schedule'],
                'meals'     => $summary['meals'],
                'start'     => $data['start_date'],
                'name'      => $data['name'],
                'phone'     => $data['phone'],
                'building'  => $data['building'],
                'room'      => $data['room_no'] ?? '',
            ],
        ];
        if (! empty($data['email'])) {
            $payload['customer_email'] = $data['email'];
        }

        try {
            $response = Http::withToken($secret)
                ->withOptions(['verify' => filter_var(config('arusuvai.stripe.verify_ssl'), FILTER_VALIDATE_BOOLEAN)])
                ->asForm()
                ->post('https://api.stripe.com/v1/checkout/sessions', $payload);
        } catch (\Throwable $e) {
            Log::error('Stripe connection failed: ' . $e->getMessage());
            return back()->withErrors(['payment' => __('Could not reach the payment gateway. Please try again.')])->withInput();
        }

        if ($response->failed()) {
            Log::error('Stripe error', $response->json() ?? []);
            return back()->withErrors(['payment' => $response->json('error.message') ?? __('Payment could not be started.')])->withInput();
        }

        session(['stripe_session' => $response->json('id')]);

        return redirect()->away($response->json('url'));
    }

    public function success(Request $request)
    {
        $booking = session('booking');
        $status  = $request->query('mode', 'paid');

        // Confirm with Stripe when we come back from Checkout
        if ($sessionId = $request->query('session_id')) {
            $status = 'pending';
            $secret = config('arusuvai.stripe.secret');
            if ($secret) {
                try {
                    $res = Http::withToken($secret)
                        ->withOptions(['verify' => filter_var(config('arusuvai.stripe.verify_ssl'), FILTER_VALIDATE_BOOLEAN)])
                        ->get('https://api.stripe.com/v1/checkout/sessions/' . urlencode($sessionId));
                    if ($res->ok() && $res->json('payment_status') === 'paid') {
                        $status = 'paid';
                        $booking = $booking ?? [];
                        $booking['total']     = $res->json('amount_total') / 100;
                        $booking['reference'] = $res->json('client_reference_id') ?? ($booking['reference'] ?? '');
                    }
                } catch (\Throwable $e) {
                    Log::warning('Stripe verify failed: ' . $e->getMessage());
                }
            }
        }

        return view('pages.payment-success', compact('booking', 'status'));
    }

    public function cancel()
    {
        return view('pages.payment-cancel', ['booking' => session('booking')]);
    }
}
