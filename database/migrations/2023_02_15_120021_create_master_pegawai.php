<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterPegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');
            $table->foreignId('master_region_id')->nullable()->constrained('master_region');
            $table->integer('nip')->unique()->comment('diisi dengan code [master_cabang_id + dmy + CountTotalPegawaiCabang]');
            $table->enum('jabatan', ['KEPALA REGION','DRIVER','STAFF', 'KEPALA CABANG'])->comment('toUpper semua');
            $table->enum('role', ['admin', 'super-admin', 'kepala-cabang', 'kepala-region', 'staff'])->comment('menggunakan slug "-"');
            $table->enum('status', ['aktif', 'in-aktif'])->comment('menggunakan slug "-"');
            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->softDeletes();
        });

        $data= [
            [
                'name' => 'Super Admen',
                'email' => 'superadmin@mail.com',
                'password' => bcrypt('123456789'),
                'master_region_id' => null,
                'nip' => '1',
                'jabatan' => 'STAFF',
                'role' => 'super-admin',
                'status' => 'aktif',
            ],
            [
                'name' => 'Kepala Region II',
                'email' => 'kepalaregion@mail.com',
                'password' => bcrypt('123456789'),
                'master_region_id' => \App\Models\MasterRegion::all()->random()->id,
                'nip' => '2',
                'jabatan' => 'KEPALA REGION',
                'role' => 'kepala-region',
                'status' => 'aktif',
            ]
            ,[
                'name' => 'STAFF',
                'email' => 'staff@mail.com',
                'password' => bcrypt('123456789'),
                'master_region_id' => \App\Models\MasterRegion::all()->random()->id,
                'nip' => '3',
                'jabatan' => 'STAFF',
                'role' => 'kepala-region',
                'status' => 'aktif',
            ]
            ,[
                'name' => 'Driver',
                'email' => 'driver@mail.com',
                'password' => bcrypt('123456789'),
                'master_region_id' => \App\Models\MasterRegion::all()->random()->id,
                'nip' => '4',
                'jabatan' => 'DRIVER',
                'role' => 'staff',
                'status' => 'aktif',
            ]
        ];

        foreach ($data as $key => $value) {
            \App\Models\User::create($value);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_pegawai');
    }
}
