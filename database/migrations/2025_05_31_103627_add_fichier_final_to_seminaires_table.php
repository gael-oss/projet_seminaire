<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFichierFinalToSeminairesTable extends Migration
{
    public function up(): void
    {
        Schema::table('seminaires', function (Blueprint $table) {
            $table->string('fichier_final')->nullable()->after('statut');
        });
    }

    public function down(): void
    {
        Schema::table('seminaires', function (Blueprint $table) {
            $table->dropColumn('fichier_final');
        });
    }
}
