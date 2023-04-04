<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $paymentTypes = [
            [
                'name' => 'Debit Card',
                'description' => 'Debit card payment',
                'icon' => 'fas fa-credit-card',
                'supplement' => 0.15,
            ],
            [
                'name' => 'Bancontact',
                'description' => 'Bancontact payment',
                'icon' => 'fas fa-credit-card',
                'supplement' => 0.4,
            ],
            [
                'name' => 'Credit Card',
                'description' => 'Credit card payment',
                'icon' => 'fas fa-credit-card',
                'supplement' => 0.35,
            ],
            [
                'name' => 'PayPal',
                'description' => 'PayPal payment',
                'icon' => 'fab fa-paypal',
                'supplement' => 0.5,
            ],
            [
                'name' => 'Bank Transfer',
                'description' => 'Bank transfer payment',
                'icon' => 'fas fa-university',
                'supplement' => 0,
            ],
            [
                'name' => 'Bitcoin',
                'description' => 'Bitcoin payment',
                'icon' => 'fab fa-bitcoin',
                'supplement' => 0,
            ]
        ];

        foreach ($paymentTypes as $paymentType) {
            \App\Models\PaymentType::create($paymentType);
        }
    }
}
