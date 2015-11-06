<?php

use Illuminate\Database\Seeder;
use App\Models\Article;
//如果提示[Class ArticlesTableSeeder does not exist ]需要运行composer dump-autoload
class ArticlesTableSeeder extends Seeder
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
