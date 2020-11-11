<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'name'     => 'En attente',
            ],
            [
                'name'     => 'En cour',
            ],
            [
                'name'     => 'Terminé',
            ]
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
