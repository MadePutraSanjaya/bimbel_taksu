<?php

use App\Enums\StatusHadir;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah_hadir')->default(0);
            $table->integer('jumlah_alpha')->default(0);
            $table->enum('status', [StatusHadir::HADIR->value, StatusHadir::ALPHA->value, StatusHadir::IZIN->value,])->default(StatusHadir::ALPHA->value,);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
