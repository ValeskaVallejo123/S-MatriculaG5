<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateSuperAdminEmailSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'superadmin@escuelagabrielamistral.edu.hn')->first();
        
        if ($user) {
            $user->email = 'superadmin@egm.edu.hn';
            $user->save();
            
            $this->command->info(' Email del Super Admin actualizado correctamente');
        } else {
            $this->command->error(' No se encontró el Super Admin');
        }
    }
}