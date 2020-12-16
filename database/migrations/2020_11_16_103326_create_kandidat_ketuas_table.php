<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKandidatKetuasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kandidat_ketuas', function (Blueprint $table) {
            $table->id();
            $table->string('no_urut');
            $table->string('nm_lengkap');
            $table->string('slug');
            $table->string('npm');
            $table->string('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('prodi');
            $table->string('jenjang_prodi');
            $table->string('telephone');
            $table->string('banner')->nullable();
            $table->enum('status_kandidat',['1','0'])->default('0');
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
        Schema::dropIfExists('kandidat_ketuas');
    }
}
