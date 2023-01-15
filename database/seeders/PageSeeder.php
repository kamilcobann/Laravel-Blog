<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $pages = ['Hakkımızda','Kariyer','Vizyonumuz','Misyonumuz'];
        $count = 0;
        foreach($pages as $page){
            $count++;
            DB::table('pages')->insert([
                'title' => $page,
                'slug' =>str_slug($page),
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSflOK8DK_qvUA5mTi6rp6qgYLJnL26AU_jPQ&usqp=CAU',
                'content' =>' Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi qui sequi odit iusto esse optio, rem,
                 impedit assumenda similique placeat a deserunt inventore quo totam provident aperiam. Eligendi esse rem provident
                 minus optio placeat dolorum! Error assumenda illo, ab alias veritatis rem placeat doloribus dolor, deleniti dicta nesciunt
                , repudiandae dolores?',
                'order'=> $count,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }
    }
}
