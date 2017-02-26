<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create(['name' => 'Admin', 'slug' => 'admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('admin')]);
        $editor = User::create(['name' => 'Editor', 'slug' => 'editor', 'email' => 'editor@gmail.com', 'password' => bcrypt('editor')]);
        $member = User::create(['name' => 'Member', 'slug' => 'member', 'email' => 'member@gmail.com', 'password' => bcrypt('member')]);
        
        $admin->roles()->attach(1);
        $editor->roles()->attach(2);
        $member->roles()->attach(3);
    }
}
