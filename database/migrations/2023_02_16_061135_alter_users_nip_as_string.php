<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersNipAsString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('users', function (Blueprint $table) {
            $table->string('nip')->comment('diisi dengan code [region-id + dmy + CountTotalPegawaiCabang]')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('users', function (Blueprint $table) {
            $table->integer('nip')->unique()->comment('diisi dengan code [master_cabang_id + dmy + CountTotalPegawaiCabang]');
        });
    }
}
