<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::create([
        'name' => 'ORNEK E-ticaret',
        'content' => 'Hakkımızda yazısı burada.',
        'text_1_icon' => 'icon-truck',
        'text_1' => 'Ücretsin Kargo',
        'text_1_content' => 'Ürünlerinizde ücretsiz kargo sağlarız.',
        'text_2_icon' => 'icon-refresh2',
        'text_2' => 'Geri İade',
        'text_2_content' => '30 gün içerisinde geri iade sağlarız.',
        'text_3_icon' => 'icon-help',
        'text_3' => 'Destek',
        'text_3_content' => '7/24 bize ulaşabilirsiniz.',
        ]);
    }
}
