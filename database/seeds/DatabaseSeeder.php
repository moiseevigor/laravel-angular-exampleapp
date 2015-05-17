<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Role;
use App\User;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('RoleTableSeeder');
		$this->call('UserTableSeeder');
	}

}

class RoleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();

        Role::create(array(
        	'id' => 1,
        	'name' => 'Admin',
        	));

        Role::create(array(
            'id' => 2,
            'name' => 'Consumer',
            ));

        Role::create(array(
            'id' => 3,
            'name' => 'Guest',
            ));

    }

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
        	'name' => 'Mario Rossi',
        	'email' => 'mario.rossi@libero.it',
        	'password' => Hash::make('123456'),
        	'role_id' => 1
        	));

        User::create(array(
        	'name' => 'Pinco Pallino',
        	'email' => 'pinco.pallino@libero.it',
        	'password' => Hash::make('123456'),
        	'role_id' => 2
        	));
    }

}