<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $user= App\User::create(
          [
            'name' => 'Thomas Chirwa',
            'email' => 'Thomas-bongani@hotmail.com',
            'password' =>bcrypt('Thomas@9194Thomas'),
            'admin' =>1
        ]);

        App\profile::create([
            'user_id' => $user->id,
            'avatar' => 'admin.jpg',
            'about' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
            'dob' => '1994 06 10'
        ]);
}

}