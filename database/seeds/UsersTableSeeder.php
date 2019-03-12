<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User([
            'name' => 'Guest',
            'email' => 'guest@example.com',
            'password' => Crypt::encrypt('password'),
        ]);
        $user->save();
    }
}
