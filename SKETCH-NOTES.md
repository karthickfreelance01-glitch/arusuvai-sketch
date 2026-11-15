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

## Static deploy (Render Static Site)
Render static sites can't run PHP, so the site is exported to plain HTML:

    php artisan export:static      # writes ./dist  (English at /, Tamil /ta, Malayalam /ml, Hindi /hi)

Commit and push `dist/`, then on Render: Build Command `echo "prebuilt"`, Publish Directory `dist`.
Re-run the export and push again whenever you change a page.

Stripe on the static site uses **Payment Links** (no server needed). Create one per plan in
Stripe Dashboard → Payment Links (currency AED, "Allow promotion codes" on, after-payment
redirect to `https://YOUR-SITE/payment/success/?mode=paid`), then add to .env before exporting:

    SITE_URL=https://arusuvai-sketch.onrender.com
    STRIPE_LINK_3_MON_SUN=https://buy.stripe.com/...
    STRIPE_LINK_3_MON_SAT=...
    STRIPE_LINK_3_MON_FRI=...
    STRIPE_LINK_2_MON_SUN=...
    STRIPE_LINK_2_MON_SAT=...
    STRIPE_LINK_2_MON_FRI=...
    STRIPE_LINK_1_MON_SUN=...

A plan without a link falls back to the demo success page.
