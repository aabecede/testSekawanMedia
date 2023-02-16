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
}
