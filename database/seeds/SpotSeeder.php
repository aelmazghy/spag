<?php


use Illuminate\Database\Seeder;
use App\Spot;

class SpotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spots = [
            [
                'name'     => 'Reception',
                'slug'    => 'reception'
            ],
            [
                'name'     => 'Salle Dubaï',
                'slug'    => 'salle-dubai'
            ],
            [
                'name'     => 'Salle Rio',
                'slug'    => 'salle-rio'

            ],
            [
                'name'     => 'Salle Bali',
                'slug'    => 'salle-bali'

            ],
            [
                'name'     => 'Salle Miami',
                'slug'    => 'salle-miami'

            ]
        ];

        foreach ($spots as $spot) {
            Spot::create($spot);
        }
    }
}
