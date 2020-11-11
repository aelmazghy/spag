<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StatusSeeder::class,
            SpotSeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
        ]);

        exec('php artisan passport:install');
        exec('php artisan optimize:clear');
    }
}
