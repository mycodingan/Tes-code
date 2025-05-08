<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasTable extends Migration
{
    public function up()
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            // $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade'); //pakai ini kenapa malah error
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('kelas');
    }
}
    