<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [
            [
                'name' => 'Monthly Subscription',
                'duration' => 'month',
                'price' => 9.99,
                'paypal_plan_id' => 'MONTHLY_PLAN_ID', // Replace with actual PayPal plan ID
            ],
            [
                'name' => 'Yearly Subscription',
                'duration' => 'year',
                'price' => 99.99,
                'paypal_plan_id' => 'YEARLY_PLAN_ID', // Replace with actual PayPal plan ID
            ],
            [
                'name' => 'Lifetime Subscription',
                'duration' => 'lifetime',
                'price' => 299.99,
                'paypal_plan_id' => 'LIFETIME_PLAN_ID', // Replace with actual PayPal plan ID
            ],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}