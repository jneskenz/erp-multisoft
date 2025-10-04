<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserCustomization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserCustomizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear personalizaciones para usuarios existentes
        $users = User::all();
        
        foreach ($users as $user) {
            // Solo crear si no existe una personalización
            if (!$user->customization) {
                UserCustomization::create([
                    'user_id' => $user->id,
                    ...UserCustomization::getDefaults()
                ]);
            }
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Asignar rol de admin al primer usuario (si no lo tiene)
        
        $customizationPermissions = [
            'customization.view',
            'customization.show',
            'customization.create',
            'customization.edit',
            'customization.delete',
        ];

        foreach ($customizationPermissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $adminRole->givePermissionTo($customizationPermissions);

        $firstUser = User::first();
        if ($firstUser && !$firstUser->hasRole('admin')) {
            $firstUser->assignRole('admin');
        }


    }
}
