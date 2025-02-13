<?php

use App\Enums\StatusMengajar;
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
        Schema::create('mata_pembelajarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pembelajaran');
            $table->foreignId('kelas_id')->constrained()->onDelete('cascade');
            $table->enum('status', [StatusMengajar::SUDAH_MENGAJAR->value, StatusMengajar::BELUM_MENGAJAR->value])->default(StatusMengajar::BELUM_MENGAJAR->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_pembelajarans');
    }
};
