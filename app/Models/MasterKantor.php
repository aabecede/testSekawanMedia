<?php

namespace App\Models;

use App\Http\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterKantor extends Model
{
    use HasFactory;
    use CrudTrait;
    use SoftDeletes;

    protected $table = 'master_kantor';
    protected $guarded = ['id'];
    /**ENUM DB */
    static public $tipeKantor = [
        'UTAMA','CABANG'
    ];

    public function master_region(){
        return $this->hasOne(MasterRegion::class, 'id', 'region_id');
    }
}
