<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Role, App\User, App\Form, App\Order, App\Permission;

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
        $this->call('CapTableSeeder');

	}

}

class RoleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();

        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'Administrator';
        $admin->description  = 'User is allowed to manage and edit other users, forms and orders of other users';
        $admin->save();

        $consumer = new Role();
        $consumer->name         = 'consumer';
        $consumer->display_name = 'Consumer';
        $consumer->description  = 'User is allowed to manage and edit his own forms and orders';
        $consumer->save();

        /*  
         * USERS PERMISSIONS
         */
        $indexUser = new Permission();
        $indexUser->name         = 'index-user';
        $indexUser->display_name = 'List Users';
        $indexUser->save();

        $createUser = new Permission();
        $createUser->name         = 'create-user';
        $createUser->display_name = 'Create Users';
        $createUser->save();

        $storeUser = new Permission();
        $storeUser->name         = 'store-user';
        $storeUser->display_name = 'Store Users';
        $storeUser->save();

        $updateUser = new Permission();
        $updateUser->name         = 'update-user';
        $updateUser->display_name = 'Updates Users';
        $updateUser->save();

        $editUser = new Permission();
        $editUser->name         = 'edit-user';
        $editUser->display_name = 'Edit Users';
        $editUser->save();

        $destroyUser = new Permission();
        $destroyUser->name         = 'destroy-user';
        $destroyUser->display_name = 'Destroy Users';
        $destroyUser->save();

        $admin->attachPermissions(array($indexUser, $createUser, $storeUser, $updateUser, $editUser, $destroyUser));

        /**  
         * FORMS PERMISSIONS
         */
        $indexForm = new Permission();
        $indexForm->name         = 'index-form';
        $indexForm->display_name = 'List Forms';
        $indexForm->save();

        $createForm = new Permission();
        $createForm->name         = 'create-form';
        $createForm->display_name = 'Create Forms';
        $createForm->save();

        $storeForm = new Permission();
        $storeForm->name         = 'store-form';
        $storeForm->display_name = 'Store Forms';
        $storeForm->save();

        $updateForm = new Permission();
        $updateForm->name         = 'update-form';
        $updateForm->display_name = 'Updates Forms';
        $updateForm->save();

        $editForm = new Permission();
        $editForm->name         = 'edit-form';
        $editForm->display_name = 'Edit Forms';
        $editForm->save();

        $destroyForm = new Permission();
        $destroyForm->name         = 'destroy-form';
        $destroyForm->display_name = 'Destroy Forms';
        $destroyForm->save();

        $admin->attachPermissions(array($indexForm, $createForm, $storeForm, $updateForm, $editForm, $destroyForm));
        $consumer->attachPermissions(array($indexForm, $createForm, $storeForm, $updateForm, $editForm, $destroyForm));

        /**  
         * ORDERS PERMISSIONS
         */
        $indexOrder = new Permission();
        $indexOrder->name         = 'index-order';
        $indexOrder->display_name = 'List Orders';
        $indexOrder->save();

        $createOrder = new Permission();
        $createOrder->name         = 'create-order';
        $createOrder->display_name = 'Create Orders';
        $createOrder->save();

        $storeOrder = new Permission();
        $storeOrder->name         = 'store-order';
        $storeOrder->display_name = 'Store Orders';
        $storeOrder->save();

        $updateOrder = new Permission();
        $updateOrder->name         = 'update-order';
        $updateOrder->display_name = 'Updates Orders';
        $updateOrder->save();

        $editOrder = new Permission();
        $editOrder->name         = 'edit-order';
        $editOrder->display_name = 'Edit Orders';
        $editOrder->save();

        $destroyOrder = new Permission();
        $destroyOrder->name         = 'destroy-order';
        $destroyOrder->display_name = 'Destroy Orders';
        $destroyOrder->save();

        $admin->attachPermissions(array($indexOrder, $createOrder, $storeOrder, $updateOrder, $editOrder, $destroyOrder));
        $consumer->attachPermissions(array($indexOrder, $createOrder, $storeOrder, $updateOrder, $editOrder, $destroyOrder));
    }

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        $admin = Role::where('name', '=', 'admin')->first();
        $consumer = Role::where('name', '=', 'consumer')->first();

        $user1 = User::create(array(
        	'name' => 'Mario Rossi',
        	'email' => 'mario.rossi@libero.it',
        	'password' => Hash::make('123456'),
        	));
        $user1->roles()->attach($admin->id);

        $user2 = User::create(array(
        	'name' => 'Pinco Pallino',
        	'email' => 'pinco.pallino@libero.it',
        	'password' => Hash::make('123456'),
        	));
        $user2->roles()->attach($consumer->id);
    }

}

class CapTableSeeder extends Seeder {

    public function run()
    {
        DB::table('caps')->delete();

        $sql = file_get_contents("database/seeds/cap.sql");
        DB::statement($sql);
    }

}