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

    public function getAttrStatusAttribute(){
        return self::$status[$this->status];
    }
}
