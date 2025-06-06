<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Insérer un seul utilisateur avec le rôle "secretaire"
        DB::table('users')->insert([
            'name' => 'Secrétaire_scientifique',
            'email' => 'secretaire@imsp.edu',
            'password' => Hash::make('123456789'), // Mot de passe à utiliser à l'inscription
            'role' => 'secretaire',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Supprimer l'utilisateur secrétaire lors du rollback
        DB::table('users')->where('email', 'secretaire@imsp.edu')->delete();
    }
};
