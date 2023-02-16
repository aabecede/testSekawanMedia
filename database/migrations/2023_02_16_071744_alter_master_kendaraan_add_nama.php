<?php

use App\Models\MasterKendaraan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMasterKendaraanAddNama extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('master_kendaraan', function (Blueprint $table) {
            $table->string('nama')->after('uuid');
        });

        $kendaraan = MasterKendaraan::get();

        foreach ($kendaraan as $key => $value) {
            $value->nama = "Super Car $key";
            $value->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('master_kendaraan', function (Blueprint $table) {
            $table->dropColumn(['nama']);
        });
    }
}
