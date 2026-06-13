<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::query()->where('slug', 'san-marcos-demo')->firstOrFail();

        $user = User::query()->firstOrCreate(
            [
                'tenant_id' => $tenant->id,
                'email' => 'recepcion@hospital.test',
            ],
            [
                'name' => 'Recepcion Demo',
                'password' => Hash::make('password'),
            ]
        );

        $user->assignRole('Recepcionista');
    }
}
