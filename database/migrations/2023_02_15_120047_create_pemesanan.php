<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('user_id')->nullable()->comment('sebagai yang mengajukan')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('master_kendaraan_id')->constrained('master_kendaraan')->nullable();
            $table->timestamp('tanggal_penggunaan_at');
            $table->longText('keterangan');
            $table->foreignId('penyetuju')->nullable()->comment('sebagai yang menyetujui')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('driver')->nullable()->comment('sebagai yang driver')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->softDeletes();
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
        Schema::dropIfExists('pemesanan');
    }
}
