<?php

namespace Database\Seeders;

use App\Models\ShopSettings;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ShopSettings::factory()->create(
            [
                'setting_name' => 'working_days',
                'data' => [false, true, false, true, false, true, true],
            ]
        );

        ShopSettings::factory()->create(
            [
                'setting_name' => 'working_hours',
                'data' => [
                    'from' => '08:00',
                    'to' => '16:00'
                ]
            ]
        );

        ShopSettings::factory()->create(
            [
                'setting_name' => 'non_working_hours',
                'data' => [
                    'from' => '12:00',
                    'to' => '12:45'
                ]
            ]
        );
    }
}
