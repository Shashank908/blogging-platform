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
            'id'       => '40d2b815-3ae8-4559-868b-7ae77942804f', 
            'name'     => 'Admin User',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('password'),
        ];
        if (User::where('id', '40d2b815-3ae8-4559-868b-7ae77942804f')->exists()) 
        {
            unset($data['email']);
            User::where('email', 'admin@admin.com')
                ->update($data);
        } else {
            User::create($data);
        }
    }
}
