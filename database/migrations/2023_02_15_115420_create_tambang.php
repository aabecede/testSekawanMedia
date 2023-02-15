<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTambang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_tambang', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('master_region_id')->constrained('master_region')->onDelete('restrict');
            $table->string('nama', 50);
            $table->longText('alamat');
            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });

        for ($i=0; $i <= 5; $i++){
            $data= [
                'master_region_id' => \App\Models\MasterRegion::all()->random()->id,
                'nama' => "Tambang - $i",
                'alamat' => \Faker\Provider\en_IN\Address::asciify(),
            ];
            \App\Models\MasterTambang::create($data);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_tambang');
    }
}
