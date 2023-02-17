<?php

namespace App\Models;

use App\Http\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterKendaraan extends Model
{
    use HasFactory;
    use CrudTrait;
    use SoftDeletes;

    protected $table = 'master_kendaraan';
    protected $guarded = ['id'];
    static $status_kendaraan = [
        'PRIBADI',
        'SEWA'
    ];
    static $status = [
        '1' => 'Aktif',
        '-1' => 'In Aktif'
    ];

    public function scopeGroupBytipe($query, String $tipe){
        // $query->groupBy('jenis_kendaraan') #contohnya macam ni
        // ->selectRaw('jenis_kendaraan');
        $query = $query->groupBy($tipe)
        ->selectRaw($tipe);

        return $query;
    }

    public function scopeKendaraanAktif($query){
        $query->where('status', 1);
    }


    public function pemesanan_kendaraan(){
        return $this->hasMany(Pemesanan::class, 'master_kendaraan_id', 'id');
    }

    public function pemesanan_kendaraan_aktif(){
        return $this->pemesanan_kendaraan()->whereIn('status', [1,2,3]);
    }

    public function getAttrStatusAttribute(){
        return self::$status[$this->status];
    }

    public function getAttrDetailKendaraanAttribute(){
        return "$this->nama - $this->jenis_kendaraan - MAX Tangki: $this->max_tangki - KM : ". globalNumberFormat($this->current_km);
    }
}
