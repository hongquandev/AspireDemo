<?php

namespace Database\Seeders;

use App\Models\User;
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
                'id' => 1,
                'name' => 'Dev Testing 01',
                'email' => 'devtesting@gmail.com',
                'password' => '$2y$10$ct2fHs7j1ZRZY/WpgmpHq.FtZLEVpJJ0HCw2TPZI955MH.NcLZVvK',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
