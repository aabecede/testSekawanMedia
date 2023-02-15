<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterRegion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_region', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('nama', 50);
            $table->longText('alamat');
            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });

        $arr_lokasi = [
            'SURABAYA','MALANG', 'PASURUAN', 'BANGIL', 'PROBOLINGGO', 'LUMAJANG'
        ];
        $data = [];
        $i = 0;
        while (1){
            if($i == count($arr_lokasi)){
                break;
            }
            $data[] = [
                'nama' => $arr_lokasi[$i],
                'alamat' => "Jalan ".$arr_lokasi[$i],
            ];
            $i++;
        }
        foreach ($data as $key => $value){
            $region = new \App\Models\MasterRegion;
            foreach ($value as $field => $item){
                $region->$field = $item;
            }
            $region->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_region');
    }
}
