# Arusuvai Mess – static sketch

Static Laravel 10 demo for client review. All content comes from `config/arusuvai.php`
(plans, prices, weekly menu, contacts, demo customer). No database needed.

## Run
    php artisan serve        # or http://localhost/arusuvai-sketch/public on XAMPP

## Pages
Public: `/`, `/menu`, `/book-now` (3-step wizard + Stripe), `/meal-change`, `/login`, `/register`
Customer: `/account`, `/account/track`, `/account/subscription`, `/account/rewards`, `/account/notifications`, `/account/profile`
Admin: `/admin`, `/admin/subscribers`, `/admin/deliveries`, `/admin/menu`, `/admin/payments`, `/admin/marketing`, `/admin/notifications`

## Stripe
Add to `.env` (test keys from dashboard.stripe.com → Developers → API keys):

    STRIPE_KEY=pk_test_...
    STRIPE_SECRET=sk_test_...
    STRIPE_VERIFY_SSL=true   # set false only on local XAMPP if you get "cURL error 60"

Then `php artisan config:clear`. Without STRIPE_SECRET the checkout runs in demo mode.
Test card: 4242 4242 4242 4242, any future date, any CVC.
Price is always recalculated on the server (PaymentController). Coupons: WELCOME10, BDAY20, FRIEND50.

## Languages
English, Tamil, Malayalam, Hindi via `lang/ta.json`, `lang/ml.json`, `lang/hi.json`
(switch: `/lang/{en|ta|ml|hi}`). Any string not in the file falls back to English.
