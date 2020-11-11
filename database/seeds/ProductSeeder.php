<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name'     => 'Produit test',
                'description'    => 'Produit test description',
                'vSal_Base'    => '8'
            ],
        ];

        foreach ($products as $product) {
            \App\Product::create($product);
        }    }
}
