<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMasterKendaraanAtSeveralField1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('master_kendaraan', function (Blueprint $table) {
            $table->float('max_tangki')->nullalbe()->comment('Kapatitas tangki');
            $table->float('current_km', 20, 4)->nullalbe()->comment('Current KM');
            $table->integer('status')->default(1)->comment('-1 = in aktif, 1 aktif');
            $table->renameColumn('tanggal_sewa_start_at', 'tanggal_beli_sewa_at')->comment('Digunakan untuk flag tanggal beli / sewa');
            $table->renameColumn('tanggal_sewa_end_at', 'tanggal_jual_sewa_at')->comment('Digunakan untuk flag tanggal jual / sewa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('master_kendaraan', function (Blueprint $table) {
            $table->dropColumn([
                'max_tangki',
                'current_km',
                'status'
            ]);
        });
    }
}
