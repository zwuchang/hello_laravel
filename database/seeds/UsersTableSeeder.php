<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(1000)->make();
        User::insert($users->makeVisible(['password','remember_token'])->toArray());

        $user = User::find(1);
        $user->name = 'admin';
        $user->email = 'admin@zhenxing.site';
        $user->password = bcrypt('admin888');
        $user->is_admin = true;
        $user->activated = true;
        $user->save();
    }
}
