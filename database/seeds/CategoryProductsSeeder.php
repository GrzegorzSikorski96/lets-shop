<?php

use App\Models\Category;
use App\Models\CategoryProduct;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategoryProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::firstOrCreate(['name' => "Mięso"], ['unit_type' => "dag"]);
        Category::firstOrCreate(['name' => "Alkohol"], ['unit_type' => "L"]);
        Category::firstOrCreate(['name' => "Owoce"], ['unit_type' => "Szt."]);
        Category::firstOrCreate(['name' => "Warzywa"], ['unit_type' => "Kg"]);
        Category::firstOrCreate(['name' => "Pieczywo"], ['unit_type' => "Szt."]);

        $faker = Faker::create();

        foreach(Category::all() as $category){
            CategoryProduct::firstOrCreate(['name' => $faker->name], ['category_id' => $category->id]);
        }
    }
}
