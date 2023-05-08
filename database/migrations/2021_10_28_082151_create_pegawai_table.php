<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->nullable();
            $table->string('alamat', 100)->nullable();
            $table->string('jenis_kel', 1)->nullable();
            $table->string('agama', 1)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('email', 20)->nullable();
            $table->string('mst_jabatan_id', 11)->nullable();
            $table->string('file_foto', 25)->nullable();
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
        Schema::dropIfExists('pegawai');
    }
}
