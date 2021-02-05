<?php

use App\User;
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
        $data = [
            'name'     => 'Admin User',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('password'),
        ];
        if (User::where('email', 'admin@admin.com')->exists()) 
        {
            unset($data['email']);
            User::where('email', 'admin@admin.com')
                ->update($data);
        } else {
            User::create($data);
        }
    }
}
