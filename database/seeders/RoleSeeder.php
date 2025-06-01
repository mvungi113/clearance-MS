<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin',
            'student',
            'hod',
            'finance',
            'library',
            'hostel',
            'sports',
            'computer_lab',
            'estate',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
