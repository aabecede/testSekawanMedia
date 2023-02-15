<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKantor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_kantor', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('region_id')->constrained('master_region')->onDelete('restrict');
            $table->enum('tipe_kantor', ['UTAMA', 'CABANG']);
            $table->string('nama', 50);
            $table->longText('alamat');
            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete()
->cascadeOnUpdate();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->restrictOnDelete()
->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->restrictOnDelete()
->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'region_id' => \App\Models\MasterRegion::first()->id,
                'nama' => 'Kantor PUSAT Surabaya WARU',
                'alamat' => 'Jl Waru nasional',
            ],
            [
                'region_id' => \App\Models\MasterRegion::first()->id,
                'nama' => 'Kantor Cabang Surabaya GEDANGAN',
                'alamat' => 'Jl GEDANGAN nasional',
            ]
        ];
        foreach ($data as $key => $value){
            \App\Models\MasterKantor::create($value);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_kantor');
    }
}
