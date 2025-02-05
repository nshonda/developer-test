<?php

namespace Database\Seeders;

use App\Models\User;
use Bouncer;
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
        $users = User::factory(1)->create(
            [
                'username' => 'skywalker',
                'email' => 'luke@jedi.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123123')
            ]
        );

        Bouncer::assign('admin')->to($users->first());

        $others = User::factory(20)->create();
        foreach ($others as $model) {
            Bouncer::assign('regular')->to($model);
        }
    }
}
