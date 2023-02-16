<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPemesananAddStatusPemesanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('pemesanan', function (Blueprint $table) {
            $table->integer('status')->default(0)->comment('-1 = batal, 0 = ditinjau, 1 = disetujui, 2 = perjalanan, 3 = selesai')->after('driver');
            $table->integer('status_penyetuju')->default(0)->comment('-1 = batal, 0 = ditinjau, 1 = disetujui')->after('penyetuju');
            $table->integer('status_penyetuju2')->default(0)->comment('-1 = batal, 0 = ditinjau, 1 = disetujui')->after('penyetuju2');
            $table->renameColumn('tanggal_penggunaan_at', 'tanggal_keberangkatan_at');
            $table->timestamp('tanggal_pulang_at')->nullable()->after('tanggal_penggunaan_at');
            $table->float('km_start', 20, 4)->nullable()->after('tanggal_pulang_at')->comment('Kilometer keberangkatan');
            $table->float('km_end', 20, 4)->nullable()->after('km_start')->comment('Kilometer Pulang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('pemesanan', function ($table) {
            $table->renameColumn('tanggal_keberangkatan_at', 'tanggal_penggunaan_at');
            $table->dropColumn([
                'status',
                'tanggal_pulang_at',
                'km_start',
                'km_end',
                'status_penyetuju',
                'status_penyetuju2'
            ]);
        });
    }
}
