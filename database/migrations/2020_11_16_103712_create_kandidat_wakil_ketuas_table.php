<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKandidatWakilKetuasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kandidat_wakil_ketuas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kandidat_ketuas_id')->constrained('kandidat_ketuas');
            $table->string('nm_lengkap');
            $table->string('npm');
            $table->string('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('prodi');
            $table->string('jenjang_prodi');
            $table->string('telephone');
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
        Schema::dropIfExists('kandidat_wakil_ketuas');
    }
}
