<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::create([
            'name' => 'adres',
            'data' => 'Adres bilgilerim burada.'
        ]);

        SiteSetting::create([
            'name' => 'phone',
            'data' => '0539 000 00 00'
        ]);

        SiteSetting::create([
            'name' => 'email',
            'data' => 'admin@admin.com'
        ]);

        SiteSetting::create([
            'name' => 'harita',
            'data' => null,
        ]);
    }
}
