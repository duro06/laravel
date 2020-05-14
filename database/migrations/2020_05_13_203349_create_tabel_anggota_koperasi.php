<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelAnggotaKoperasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('id_koperasi');
            $table->string('alamat');            
            $table->string('role')->default('anggota');            
            $table->string('image');            
            $table->string('telepon');            
            $table->integer('status');
            $table->float('simpanan_pokok',10,2);
            $table->string('id_kelompok');            
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
        Schema::dropIfExists('members');
    }
}
