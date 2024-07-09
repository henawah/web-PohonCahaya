<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create(

            [
                'name' => 'hena wahyuni',
                'username' => 'henawah',
                'email' => 'henawah90@gmail.com',
                'password' => bcrypt('henawah')
            ]
        );

        Category::create([
            'name'=>'Anak-Anak',
            'slug'=>'anak-anak'
        ]);

        Category::create([
            'name'=>'Biografi',
            'slug'=>'biografi'
        ]);

        
        Category::create([
            'name'=>'Budaya dan Seni',
            'slug'=>'budaya-dan-seni'
        ]);

        Category::create([
            'name'=>'E-Book Pohon Cahaya Semesta',
            'slug'=>'e-book-pohon-cahaya-semesta'
        ]);

        Category::create([
            'name'=>'Informasi dan Teknologi',
            'slug'=>'informasi-dan-teknologi'
        ]);

        Category::create([
            'name'=>'Kesehatan',
            'slug'=>'kesehatan'
        ]);
        
        Category::create([
            'name'=>'Manajemen',
            'slug'=>'manajemen'
        ]);

        Category::create([
            'name'=>'Novel',
            'slug'=>'novel'
        ]);

        Category::create([
            'name'=>'Pendidikan',
            'slug'=>'Pendidikan'
        ]);

        Category::create([
            'name'=>'Pengembangan Diri',
            'slug'=>'pengembangan-diri'
        ]);

        Category::create([
            'name'=>'Pertanian',
            'slug'=>'pertanian'
        ]);

        Category::create([
            'name'=>'Politik dan Hukum',
            'slug'=>'politik-dan-hukum'
        ]);

        Category::create([
            'name'=>'Rohani',
            'slug'=>'rohani'
        ]);

        Category::create([
            'name'=>'Sains',
            'slug'=>'sains'
        ]);
        Post::factory(20)->create();
    }
}
