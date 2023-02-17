<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonsumsiBbm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konsumsi_bbm', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('master_kendaraan_id')->nullable()->constrained('master_kendaraan');
            $table->timestamp('tanggal_isi_at');
            $table->integer('total_liter');
            $table->float('total_harga', 20, 4);
            $table->longText('bukti_struk');
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
        Schema::dropIfExists('konsumsi_bbm');
    }
}
