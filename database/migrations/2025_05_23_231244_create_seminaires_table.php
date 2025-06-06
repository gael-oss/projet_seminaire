<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seminaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presentateur_id')->constrained('users'); // À la place de user_id
            $table->string('theme'); // À la place de titre
            $table->date('date_presentation');
            $table->text('resume')->nullable();
            $table->string('fichier')->nullable();
            $table->enum('statut', ['soumis', 'validé', 'rejeté', 'publié'])->default('soumis');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seminaires');
    }
};
