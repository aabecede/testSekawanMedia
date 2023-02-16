<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersAddPenyetuju2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('pemesanan', function (Blueprint $table) {
            $table->foreignId('penyetuju2')->nullable()->comment('sebagai yang menyetujui')->constrained('users')->restrictOnDelete()->cascadeOnUpdate()->after('penyetuju');
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
            $table->dropColumn(['penyetuju2']);
        });
    }
}
