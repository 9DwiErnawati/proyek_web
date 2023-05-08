<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatPangkatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_pangkat', function (Blueprint $table) {
            $table->id();
            $table->string('pegawai_id', 11);
            $table->string('mst_pangkat_id', 11);
            $table->date('tanggal_tmt_pangkat');
            $table->string('no_sk_pangkat', 25);
            $table->string('gaji_pokok', 11);
            $table->string('status', 11);
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
        Schema::dropIfExists('riwayat_pangkat');
    }
}
