<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'M Baraja',
                'email' => 'bara123@gmail.com',
                'role' => 'admin',
                'email_verified_at' => NULL,
                'password' => '$2y$12$KFApm9qpjJe2zCAf8pQLyesaW2knwTbU17tcKsTjcPbLzRGyoYcvy',
                'remember_token' => NULL,
                'created_at' => '2025-08-12 11:23:18',
                'updated_at' => '2025-08-12 11:23:18',
            ),
        ));
        
        
    }
}