<?php

namespace App\Models;

use App\Http\Traits\CrudTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static $enum_jabatan = ['KEPALA REGION', 'KEPALA CABANG', 'DRIVER', 'STAFF'];
    static $enum_role = ['admin', 'super-admin', 'kepala-cabang', 'kepala-region', 'staff'];
    static $enum_status = ['aktif', 'in-aktif'];

/**SCOPE */
    public function scopeDriver($query)
    {
        $query->whereJabatan('DRIVER');
        return $query;
    }
    public function scopeJabatanKepala($query)
    {
        $query->whereIn('jabatan', ["KEPALA CABANG", "KEPALA REGION"]);
        return $query;
    }
    public function scopeNotDriver($query)
    {
        $query->where('jabatan', '!=', 'DRIVER');
        return $query;
    }

/** END SCOPE */

/**ATTRIBUTE */
    public function getAttrStatusAttribute(){
        return strtoupper($this->status);
    }

    public function getAttrRoleAttribute(){
        return explodeImplode(strtoupper($this->role));
    }

    public function getAttrIsAdminAttribute(){
        if(in_array($this->role, ['super-admin', 'admin'])){
            return true;
        }
        return false;
    }

    public function getAttrUserJabatanAttribute(){
        return $this->name.' - '.$this->jabatan;
    }
/**END ATTRIBUTE */

/**RELATION */
    public function pemesanan_driver(){
        return $this->hasMany(Pemesanan::class, 'driver', 'id');
    }

    public function pemesanan_driver_aktif(){
        return $this->pemesanan_driver()->whereIn('status', [2, 3]);
    }
/**END RELATION */
}
