<?php

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
            for($i = 0; $i < 100; $i++){
                Article::create([
			        'name' => $faker->name,
			        'description' => $faker->sentence(10),
			        'content' => $faker->text(200),
			        'author' => $faker->numberBetween(1,10),
                ]);
            }
    }
}
