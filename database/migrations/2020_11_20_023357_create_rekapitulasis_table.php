<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapitulasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekapitulasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kandidat_ketuas_id')->constrained('kandidat_ketuas');
            $table->unsignedBigInteger('jadwal_id')->constrained('jadwals');
            $table->string('npm_pemilih');
            $table->string('prodi_pemilih');
            $table->string('fakultas_pemilih');
            $table->string('angkatan_pemilih');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekapitulasis');
    }
}
