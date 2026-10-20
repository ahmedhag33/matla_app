<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CreateCountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'الجنية المصرى',
                'code' => 'EGP',
                'symbol' => 'ج.م',
                'country' => [
                    'name' => 'مصر',
                    'code' => 'EG',
                    'timezone' => 'Africa/Cairo',
                    'utc' => 'UTC+2',
                ],
            ],
            [
                'name' => 'الدولار الامريكى',
                'code' => 'USD',
                'symbol' => '$',
                'country' => null,
            ],
            [
                'name' => 'الريال السعودى',
                'code' => 'SAR',
                'symbol' => 'ر.س',
                'country' => [
                    'name' => 'السعودية',
                    'code' => 'SA',
                    'timezone' => 'Asia/Riyadh',
                    'utc' => 'UTC+3',
                ],
            ],
            [
                'name' => 'الدرهم االمارتى',
                'code' => 'AED',
                'symbol' => 'د.ا',
                'country' => [
                    'name' => 'الامارات',
                    'code' => 'AE',
                    'timezone' => 'Asia/Dubai',
                    'utc' => 'UTC+4',
                ],
            ],
            [
                'name' => 'الريال القطرى',
                'code' => 'QAR',
                'symbol' => 'ر.ق',
                'country' => [
                    'name' => 'قطر',
                    'code' => 'QA',
                    'timezone' => 'Asia/Qatar',
                    'utc' => 'UTC+4',
                ],
            ],
            [
                'name' => 'الريال الكويتى',
                'code' => 'KWD',
                'symbol' => 'ك.د',
                'country' => [
                    'name' => 'الكويت',
                    'code' => 'KW',
                    'timezone' => 'Asia/Kuwait',
                    'utc' => 'UTC+3',
                ],
            ],
            [
                'name' => 'الليرة اللبنانية',
                'code' => 'LBP',
                'symbol' => 'ل.ل',
                'country' => [
                    'name' => 'لبنان',
                    'code' => 'LB',
                    'timezone' => 'Asia/Beirut',
                    'utc' => null
                ],
            ]
        ];
        foreach ($data as $item) {
            runTransaction(function () use ($item) {
               $currency = Currency::create([
                    'name' => $item['name'],
                    'code' => $item['code'],
                    'symbol' => $item['symbol'],
                ]);
                // create country
                if (isset($item['country'])) {
                    Country::create(array_merge($item['country'], ['currency_id' => $currency->id]));
                }
            });
        }
    }
}
