<?php

use Illuminate\Database\Seeder;

class PCTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = \App\Post::all();

        for ($i = 1; $i <= $post->count(); $i++) {
            DB::table('category_post')->insert([
                'post_id' => $i,
                'category_id' => $i,
            ]);
        }
    }
}
