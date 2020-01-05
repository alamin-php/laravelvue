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
		DB::table('users')->insert([
			'name' => 'Admin',
			'email' =>'admin@blog.com',
			'password' => Hash::make('rootadmin'),
			'type' => 'admin',
		]);		
		DB::table('users')->insert([
			'name' => 'User',
			'email' =>'user@blog.com',
			'password' => Hash::make('rotuser'),
			'type' => 'user',
		]);
    }
}
