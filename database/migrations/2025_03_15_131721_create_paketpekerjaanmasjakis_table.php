<?php

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
        Schema::create('paketpekerjaanmasjakis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prosespaket_id')->nullable();
            $table->foreignId('profiljenispekerjaan_id')->nullable();
            $table->foreignId('paketstatuspekerjaan_id')->nullable();
            $table->foreignId('sumberdana_id')->nullable();
            $table->string('namapekerjaan')->nullable();
            $table->string('tahunpilihan_id')->nullable();
            $table->string('cvptpenyedia')->nullable();
            $table->string('nib')->nullable();
            $table->decimal('nilaikontrak', 15, 2)->nullable(); // Menggunakan tipe decimal untuk nilai kontrak
            // $table->string('sumberdana')->nullable();
            $table->string('jeniskontrak')->nullable();
            $table->string('karakteristikkontrak')->nullable();
            $table->string('bulanmulai')->nullable(); // Menyimpan tanggal mulai
            $table->string('bulanselesai')->nullable(); // Menyimpan tanggal selesai
            $table->string('dinas')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paketpekerjaanmasjakis');
    }
};
