<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::deleteDirectory('profile_photos');
        Storage::makeDirectory('profile_photos');

        factory(\App\Role::class, 1)->create([
            'name' => 'Administrador'
        ]);

        factory(\App\Role::class, 1)->create([
            'name' => 'Psicólogo'
        ]);

        factory(\App\Role::class,1)->create([
            'name' => 'Paciente'
        ]);

        factory(\App\User::class, 1)->create([
            'username' => 'admin',
            'role_id' => \App\Role::ADMIN
        ]);

        factory(\App\User::class, 2)->create([
            'role_id' => \App\Role::EMPLOYEE
        ])->each(function (\App\User $user){
            factory(\App\Employee::class, 1)->create([
                'user_id' => $user->id
            ]);
        });

        factory(\App\User::class, 50)->create([
           'role_id' => \App\Role::PATIENT
        ])->each(function (\App\User $user){
            factory(\App\Patient::class, 1)->create([
               'user_id' => $user->id
            ])->each(function (\App\Patient $patient){
                factory(\App\Record::class, 5)->create([
                   'patient_id' => $patient->id,
                   'test' => 1
                ]);

                factory(\App\Record::class, 5)->create([
                    'patient_id' => $patient->id,
                    'test' => 2
                ]);
            });
        });

    }
}
