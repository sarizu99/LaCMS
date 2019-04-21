<?php

use Illuminate\Database\Seeder;

class SiteSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\SiteSetting::create([
            'name' => 'LaCMS',
            'description' => 'LaCMS adalah custom CMS script yang dibuat menggunakan framework laravel',
            'show_at_most' => 7,
            'popular_at_most' => 7,
            'snippet_length' => 200,
        ]);
    }
}
