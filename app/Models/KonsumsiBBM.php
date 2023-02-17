<?php

namespace App\Models;

use App\Http\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KonsumsiBBM extends Model
{
    use HasFactory;
    use CrudTrait;
    use SoftDeletes;

    protected $table = 'konsumsi_bbm';
    protected $guarded = ['id'];

    /**relation */
    public function master_kendaraan(){
        return $this->hasOne(MasterKendaraan::class, 'id', 'master_kendaraan_id');
    }
    /**end relation */

    /*8atribute*/
    public function getAttrTanggalIsiFormatAttribute()
    {
        return baseDateFormat($this->tanggal_isi_at, 'j F Y H:i');
    }

    public function getAttrTotalLiterFormatAttribute(){
        return globalNumberFormat($this->total_liter).'L';
    }

    public function getAttrTotalHargaFormatAttribute(){
        return 'Rp.'. globalNumberFormat($this->total_harga);
    }
    /**end atribute */
}
