<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    protected $categories = [
        'Alimentos',
        'Bebidas',
        'Carnes',
        'Frios e laticínios',
        'Frutas, verduras e legumes',
        'Higiene',
        'Limpeza',
        'Padaria',
        'Outros',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->categories as $category){
            DB::table('categories')->insert([
                'category' => $category,
            ]);
        }
    }
}
