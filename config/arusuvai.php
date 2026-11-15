<?php

/*
|--------------------------------------------------------------------------
| Arusuvai Mess – static sketch data
|--------------------------------------------------------------------------
| Everything the sketch shows (plans, prices, menu, contacts, demo users)
| lives here so the client can review and tweak without touching views.
| Prices are in AED and are ALWAYS re-calculated on the server before a
| Stripe Checkout session is created.
*/

return [

    'brand' => [
        'name'       => 'Arusuvai Mess',
        'tagline'    => 'The Authentic Flavors of India',
        'location'   => 'Dubai Investment Park 2',
        'support'    => '0566199944',
        'delivery'   => '0522047689',
        'whatsapp'   => '971566199944',
        'email'      => 'hello@arusuvai.ae',
        'currency'   => 'AED',
    ],

    'stripe' => [
        'key'        => env('STRIPE_KEY'),
        'secret'     => env('STRIPE_SECRET'),
        'currency'   => 'aed',
        // XAMPP on Windows often ships without a CA bundle. Set
        // STRIPE_VERIFY_SSL=false only on a local dev machine.
        'verify_ssl' => env('STRIPE_VERIFY_SSL', true),
    ],

    'languages' => [
        'en' => ['label' => 'English',  'native' => 'English'],
        'ta' => ['label' => 'Tamil',    'native' => 'தமிழ்'],
        'ml' => ['label' => 'Malayalam','native' => 'മലയാളം'],
        'hi' => ['label' => 'Hindi',    'native' => 'हिन्दी'],
    ],

    // Day options and the plans' prices (from the 30-day price card)
    'schedules' => [
        'mon-sun' => ['label' => 'Monday – Sunday',   'short' => 'Mon–Sun', 'days' => 7],
        'mon-sat' => ['label' => 'Monday – Saturday', 'short' => 'Mon–Sat', 'days' => 6],
        'mon-fri' => ['label' => 'Monday – Friday',   'short' => 'Mon–Fri', 'days' => 5],
    ],

    'plans' => [
        'three' => [
            'name'       => '3 Meals Plan',
            'meals'      => 3,
            'subtitle'   => 'Breakfast + Lunch + Dinner',
            'badge'      => 'Most loved',
            'color'      => 'turmeric',
            'prices'     => ['mon-sun' => 450, 'mon-sat' => 390, 'mon-fri' => 350],
            'early_stop' => 17,
            'perks'      => ['All three meals, every selected day', 'Free menu changes', 'Priority delivery slot', 'Double reward points'],
        ],
        'two' => [
            'name'       => '2 Meals Plan',
            'meals'      => 2,
            'subtitle'   => 'Pick any two meals',
            'badge'      => 'Best value',
            'color'      => 'leaf',
            'prices'     => ['mon-sun' => 320, 'mon-sat' => 300, 'mon-fri' => 280],
            'early_stop' => 13,
            'perks'      => ['Choose your two meals', 'Free menu changes', 'Live delivery tracking', 'Reward points'],
        ],
        'one' => [
            'name'       => '1 Meal Plan',
            'meals'      => 1,
            'subtitle'   => 'Breakfast, lunch or dinner',
            'badge'      => 'Starter',
            'color'      => 'sky',
            'prices'     => ['mon-sun' => 220],
            'early_stop' => 8,
            'perks'      => ['One meal you choose', 'Menu change on request', 'Live delivery tracking', 'Reward points'],
        ],
    ],

    // Coupons accepted at checkout (validated again on the server)
    'coupons' => [
        'WELCOME10' => ['type' => 'percent', 'value' => 10, 'label' => '10% off your first month'],
        'BDAY20'    => ['type' => 'percent', 'value' => 20, 'label' => '20% birthday offer'],
        'FRIEND50'  => ['type' => 'fixed',   'value' => 50, 'label' => 'AED 50 referral discount'],
    ],

    'meal_slots' => [
        'breakfast' => ['label' => 'Breakfast', 'time' => '6:30 – 8:30 AM', 'icon' => '☀️'],
        'lunch'     => ['label' => 'Lunch',     'time' => '12:00 – 1:30 PM', 'icon' => '🍛'],
        'dinner'    => ['label' => 'Dinner',    'time' => '7:30 – 9:30 PM', 'icon' => '🌙'],
    ],

    // Weekly rotating menu (Tamil Nadu + Kerala). img = file in public/assets/img
    'menu' => [
        'Monday' => [
            'breakfast' => ['Idli, Sambar & Coconut Chutney', 'd-chutney.jpg', 'TN'],
            'lunch'     => ['Rice, Sambar, Poriyal, Rasam, Curd', 'd-plainrice.jpg', 'TN'],
            'dinner'    => ['Chapati & Veg Kurma', 'd-curry.jpg', 'TN'],
        ],
        'Tuesday' => [
            'breakfast' => ['Puttu & Kadala Curry', 's-dal.jpg', 'KL'],
            'lunch'     => ['Kerala Matta Rice, Avial, Thoran, Pappadam', 's-rice.jpg', 'KL'],
            'dinner'    => ['Appam & Vegetable Stew', 's-avial.jpg', 'KL'],
        ],
        'Wednesday' => [
            'breakfast' => ['Ghee Roast Dosa & Tomato Chutney', 'd-dosa.jpg', 'TN'],
            'lunch'     => ['Veg Pulao, Raita & Beetroot Pachadi', 'd-rice.jpg', 'TN'],
            'dinner'    => ['Parotta & Salna', 'd-curry.jpg', 'TN'],
        ],
        'Thursday' => [
            'breakfast' => ['Ven Pongal, Vada & Sambar', 'd-sambar.jpg', 'TN'],
            'lunch'     => ['Rice, Kootu, Poriyal, Rasam, Payasam', 's-rasam.jpg', 'TN'],
            'dinner'    => ['Idiyappam & Egg / Veg Curry', 'd-poriyal.jpg', 'KL'],
        ],
        'Friday' => [
            'breakfast' => ['Upma & Coconut Chutney', 'd-chutney.jpg', 'TN'],
            'lunch'     => ['Chicken / Veg Biryani & Raita', 'd-rice.jpg', 'TN'],
            'dinner'    => ['Chapati & Paneer Butter Masala', 'd-curry.jpg', 'TN'],
        ],
        'Saturday' => [
            'breakfast' => ['Masala Dosa & Sambar', 'd-dosa.jpg', 'TN'],
            'lunch'     => ['Fish Curry Meals / Veg Meals', 's-thoran.jpg', 'KL'],
            'dinner'    => ['Kothu Parotta & Raita', 'd-poriyal.jpg', 'TN'],
        ],
        'Sunday' => [
            'breakfast' => ['Poori & Potato Masala', 'd-salad.jpg', 'TN'],
            'lunch'     => ['Sunday Special Sadya with Payasam', 's-payasam.jpg', 'KL'],
            'dinner'    => ['Dosa, Sambar & Chutney', 'd-dosa.jpg', 'TN'],
        ],
    ],

    // Demo customer used across the customer dashboard
    'demo_customer' => [
        'name'      => 'Karthik Ramesh',
        'phone'     => '+971 56 619 9944',
        'email'     => 'karthik@example.com',
        'room'      => 'Room 214',
        'building'  => 'Al Hamra Labour Residence',
        'area'      => 'Dubai Investment Park 2',
        'plan'      => 'three',
        'schedule'  => 'mon-sat',
        'start'     => '2026-11-03',
        'end'       => '2026-12-02',
        'points'    => 1840,
        'tier'      => 'Gold Leaf',
        'birthday'  => '1994-11-22',
        'referral'  => 'KARTHIK50',
    ],
];
