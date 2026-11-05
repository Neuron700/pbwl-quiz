<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class TbUser extends Authenticatable
{
    protected $table = "tb_users";
    protected $primaryKey = "user_id";
    public $timestamps = false;

    protected $fillable = ["user_name", "user_password", "user_namalengkap", "user_aktif"];
    protected $hidden = ["user_password"];

    public function getAuthPassword(): string
    {
        return (string) $this->user_password;
    }
}