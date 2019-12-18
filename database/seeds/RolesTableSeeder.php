<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Role Types
         *
         */
        $RoleItems = [
            [
                'name'        => \Config::get('constants.role.superadmin'),
                'slug'        => 'superadmin',
                'description' => 'SuperAdmin Role',
                'level'       => 8,
            ],
            [
                'name'        => \Config::get('constants.role.admin'),
                'slug'        => 'admin',
                'description' => 'Admin Role',
                'level'       => 7,
            ],
            [
                'name'        => \Config::get('constants.role.seniorstaff'),
                'slug'        => 'seniorstaff',
                'description' => 'Senior Staff Role',
                'level'       => 6,
            ],
            [
                'name'        => \Config::get('constants.role.staff'),
                'slug'        => 'staff',
                'description' => 'Staff Role',
                'level'       => 5,
            ],
            [
                'name'        => \Config::get('constants.role.sit'),
                'slug'        => 'sit',
                'description' => 'Staff in Training Role',
                'level'       => 4,
            ],
            [
                'name'        => \Config::get('constants.role.intern'),
                'slug'        => 'intern',
                'description' => 'Intern Role',
                'level'       => 3,
            ],
            [
                'name'        => \Config::get('constants.role.member'),
                'slug'        => 'member',
                'description' => 'Member Role',
                'level'       => 2,
            ],
           [
                'name'        => \Config::get('constants.role.guest'),
                'slug'        => 'guest',
                'description' => 'Guest Role',
                'level'       => 1,
            ],
        ];

        /*
         * Add Role Items
         *
         */
        foreach ($RoleItems as $RoleItem) {
            $newRoleItem = config('roles.models.role')::where('slug', '=', $RoleItem['slug'])->first();
            if ($newRoleItem === null) {
                $newRoleItem = config('roles.models.role')::create([
                    'name'          => $RoleItem['name'],
                    'slug'          => $RoleItem['slug'],
                    'description'   => $RoleItem['description'],
                    'level'         => $RoleItem['level'],
                ]);
            }
        }
    }
}
