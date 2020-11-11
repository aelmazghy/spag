<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'     => 'VIP SPA',
                'email'    => 'vipspa@admin.com',
                'password' => bcrypt('vipspa8854'),
                'is_admin' => 1,
                'is_user' => 1,
                'spot_id' => 1
            ],
            [
                'name'     => 'Abdessamad',
                'email'    => 'abdess@abdess.com',
                'password' => bcrypt('vipspa8854abdess'),
                'is_admin' => 1,
                'is_user' => 1,
                'spot_id' => 1
            ],
            [
                'name'     => 'Dubaï',
                'email'    => 'dubai@vipspa.com',
                'password' => bcrypt('dubai54'),
                'is_admin' => 0,
                'is_user' => 1,
                'spot_id' => 2
            ],
            [
                'name'     => 'Rio',
                'email'    => 'rio@vipspa.com',
                'password' => bcrypt('rio54v'),
                'is_admin' => 0,
                'is_user' => 1,
                'spot_id' => 3
            ],
            [
                'name'     => 'Bali',
                'email'    => 'bali@vipspa.com',
                'password' => bcrypt('bali54p'),
                'is_admin' => 0,
                'is_user' => 1,
                'spot_id' => 4
            ],
            [
                'name'     => 'Miami',
                'email'    => 'miami@vipspa.com',
                'password' => bcrypt('miami54w'),
                'is_admin' => 0,
                'is_user' => 1,
                'spot_id' => 5
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
