<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPemesananAddAlasanPenyetuju extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('pemesanan', function (Blueprint $table) {

            $table->longText('status_alasan_penyetuju')->after('status_penyetuju')->nullable();
            $table->longText('status_alasan_penyetuju2')->after('status_penyetuju2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('pemesanan', function (Blueprint $table) {
            $table->dropColumn([
                'status_alasan_penyetuju',
                'status_alasan_penyetuju2',
            ]);
        });
    }
}
