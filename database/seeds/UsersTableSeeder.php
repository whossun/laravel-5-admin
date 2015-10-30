<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('permission_role')->truncate();
        DB::table('role_user')->truncate();
        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $faker = Faker\Factory::create();

        //User
        $admin = User::create([
            'email' => 'admin@admin.com',
            'name' => '管理员',
            'password' => bcrypt('adminadmin')
        ]);

        $test_user = User::create([
            'email' => 'test@test.com',
            'name' => '测试用户',
            'password' => bcrypt('testtest')
        ]);

        //Roles
        $role_admin = Role::create(['name' => 'admin', 'display_name' => '管理员']);
        $role_editor = Role::create(['name' => 'editor', 'display_name' => '编辑']);
        $role_user = Role::create(['name' => 'user', 'display_name' => '普通用户']);

        //Permission
        Permission::create(['name' => 'dashboard_view', 'display_name' => '管理首页']);
        Permission::create(['name' => 'users_view', 'display_name' => '帐户管理']);
        Permission::create(['name' => 'users_create', 'display_name' => '新建帐户']);
        Permission::create(['name' => 'users_update', 'display_name' => '修改帐户']);
        Permission::create(['name' => 'users_delete', 'display_name' => '删除帐户']);

        Permission::create(['name' => 'articles_view', 'display_name' => '文章管理']);
        Permission::create(['name' => 'articles_create', 'display_name' => '新建文章']);
        Permission::create(['name' => 'articles_update', 'display_name' => '修改文章']);
        Permission::create(['name' => 'articles_delete', 'display_name' => '删除文章']);

        //Roles Users
        $test_user->roles()->save($role_editor);

        //Roles Users
        // $role_admin->givePermissionTo($permission_admin_user);
    }
}
