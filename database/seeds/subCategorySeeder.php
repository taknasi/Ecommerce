<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class subCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class,20)->create([
            'parent_id'=> $this->getRandomParentId()
        ]);
    }

    private function getRandomParentId(){
        return Category::inRandomOrder()->first();
    }
}
