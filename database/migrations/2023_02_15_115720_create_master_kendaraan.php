<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterKendaraan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $enum = ['PRIBADI', 'SEWA'];
        Schema::create('master_kendaraan', function (Blueprint $table) use ($enum) {
            $table->id();
            $table->uuid('uuid');
            $table->string('jenis_kendaraan', 50)->comment('Pastikan Inputannya nanti toUpper');
            $table->enum('status_kendaraan', $enum);
            $table->string('agen_sewa', 100)->comment('Pastikan Inputannya nanti toUpper, ini diisi ketika status kendaraannya bukan milik pribadi')->nullable();
            $table->timestamp('tanggal_sewa_start_at')->nullable()->comment('Diisi jika status kendaan "SEWA"');
            $table->timestamp('tanggal_sewa_end_at')->nullable()->comment('Diisi jika status kendaraan "SEWA"');
            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [];
        $arr_jenis_kendaraan = ['JEEP', 'SEDAN', 'ELF', '4x4'];
        $arr_agency_sewa = ['SURYA ABADI', 'CENGKEH HITAM', 'ADI PATI', 'NUGROHO', 'BUNAYA'];
        $i = 0;
        while(1){
            $random_key_agency_sewa = array_rand($arr_agency_sewa, count($arr_agency_sewa));
            $random_key_jenis_kendaraan = array_rand($arr_jenis_kendaraan, count($arr_jenis_kendaraan));
            $random_key_enum = array_rand($enum, 2);
            $status_kendaraan = $enum[$random_key_enum[0]];

            if($i == 10){
                break;
            }
            $content = [
                'jenis_kendaraan' => $arr_jenis_kendaraan[$random_key_jenis_kendaraan[0]],
                'status_kendaraan' => $status_kendaraan,
            ];

            if($status_kendaraan == 'SEWA'){
                $content['agency_sewa'] = $arr_agency_sewa[$random_key_agency_sewa[0]];
                $content['tanggal_sewa_start_at'] = \Carbon\Carbon::startOfYear();
                $content['tanggal_sewa_end_at'] = \Carbon\Carbon::endOfYear();
            }

            $data = $content;
            $i++;
            \App\Models\MasterKendaraan::create($data);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_kendaraan');
    }
}
