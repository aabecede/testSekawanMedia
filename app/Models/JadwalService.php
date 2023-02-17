<?php

namespace App\Models;

use App\Http\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalService extends Model
{
    use HasFactory;
    use CrudTrait;
    use SoftDeletes;

    protected $table = 'jadwal_service';
    protected $guarded = ['id'];

    /**relation */
    public function master_kendaraan(){
        return $this->hasOne(MasterKendaraan::class, 'id', 'master_kendaraan_id');
    }
    /**end relasi */

    /**attribute */
    public function getAttrTanggalServiceFormatAttribute(){
        return baseDateFormat($this->tanggal_service_at, 'j F Y H:i');
    }
    /** */
}
