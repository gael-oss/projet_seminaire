<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('seminaires', function (Blueprint $table) {
            $table->string('statut')->default('demande')->change();
        });
    }

    public function down(): void
    {
        Schema::table('seminaires', function (Blueprint $table) {
            $table->string('statut')->change();
        });
    }
};
