<?php

namespace App\Models;

use App\Http\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemesanan extends Model
{
    use HasFactory;
    use CrudTrait;
    use SoftDeletes;

    protected $table = 'pemesanan';
    protected $guarded = ['id'];
    static $status = [
        '-1' => 'batal',
        '0' => 'ditinjau',
        '1' => 'disetujui',
        '2' => 'perjalanan',
        '3' => 'selesai'
    ];
    static $status_penyetuju = [
        '-1' => 'batal',
        '0' => 'ditinjau',
        '1' => 'disetujui',
    ];

    public function user_pengaju()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function user_penyetuju_1()
    {
        return $this->hasOne(User::class, 'id', 'penyetuju');
    }

    public function user_penyetuju_2()
    {
        return $this->hasOne(User::class, 'id', 'penyetuju2');
    }

    public function user_driver()
    {
        return $this->hasOne(User::class, 'id', 'driver');
    }

    public function master_kendaraan()
    {
        return $this->hasOne(MasterKendaraan::class, 'id', 'master_kendaraan_id');
    }

    public function getAttrTanggalPenggunaanFormatAttribute()
    {
        return baseDateFormat($this->tanggal_penggunaan_at);
    }

    public function getAttrStatusPenyetujuBadgeAttribute()
    {
        $class_badge = 'warning';
        if ($this->status_penyetuju == 1) {
            $class_badge = 'success';
        } elseif ($this->status_penyetuju == -1) {
            $class_badge = 'danger';
        }

        $result = '<span class="badge badge-' . $class_badge . '">' . ucfirst(self::$status_penyetuju[$this->status_penyetuju]) . '</span>';
        return $result;
    }

    public function getAttrStatusPenyetuju2BadgeAttribute()
    {
        $class_badge = 'warning';
        if ($this->status_penyetuju2 == 1) {
            $class_badge = 'success';
        } elseif ($this->status_penyetuju2 == -1) {
            $class_badge = 'danger';
        }

        $result = '<span class="badge badge-' . $class_badge . '">' . ucfirst(self::$status_penyetuju[$this->status_penyetuju2]) . '</span>';
        return $result;
    }
}
