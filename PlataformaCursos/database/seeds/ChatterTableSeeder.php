<?php

use Illuminate\Database\Seeder;

class ChatterTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {

        // CREATE THE CATEGORIES

        \DB::table('chatter_categories')->delete();

        \DB::table('chatter_categories')->insert([
            0 => [
                'id'         => 1,
                'parent_id'  => null,
                'order'      => 1,
                'name'       => 'lesson',
                'color'      => '#70299b',
                'slug'       => 'lesson',
                'created_at' => null,
                'updated_at' => null,
            ],
            
        ]);

        // CREATE THE DISCUSSIONS

        \DB::table('chatter_discussion')->delete();

        \DB::table('chatter_discussion')->insert([
            0 => [
                'id'                  => 1,
                'chatter_category_id' => 1,
                'title'               => 'Titulo de la leccion',
                'user_id'             => 1,
                'sticky'              => 0,
                'views'               => 0,
                'answered'            => 0,
                'created_at'          => '2018-08-10 14:27:56',
                'updated_at'          => '2018-08-10 14:27:56',
                'slug'                => 'titulo-de-la-leccion',
                'color'               => '#70299b',
            ]
        ]);

        // CREATE THE POSTS

        \DB::table('chatter_post')->delete();

        \DB::table('chatter_post')->insert([
                    0 => [
                        'id'                    => 1,
                        'chatter_discussion_id' => 1,
                        'user_id'               => 3,
                        'body'                  => 'Bienvenido',
                        'created_at' => '2018-08-11 14:27:56',
                        'updated_at' => '2018-08-11 14:27:56',
                    ]
        ]);
    }
}
