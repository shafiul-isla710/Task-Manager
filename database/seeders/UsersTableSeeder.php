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
                'name' => 'Tester',
                'email' => 'test@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$1wF1UaujnYU.h9FSOsnSa.zi9BrrVyIb3lLyPkKpeyCcCMePvkUZO',
                'profile_image' => NULL,
                'type' => 'User',
                'remember_token' => NULL,
                'created_at' => '2025-10-16 09:34:33',
                'updated_at' => '2025-10-16 09:34:33',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$5W.YTCNmUxMT3mpr2e8rPeMJCatARo.u85cW3NjL7b43Q65crxU42',
                'profile_image' => NULL,
                'type' => 'Admin',
                'remember_token' => NULL,
                'created_at' => '2025-10-16 09:35:06',
                'updated_at' => '2025-10-16 09:35:06',
            ),
        ));
        
        
    }
}