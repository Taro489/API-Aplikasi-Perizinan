<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcceptPermittions extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function User(){
        return $this->belongsTo(User::class, 'verificatorId');
    }

    public function Permittion(){
        return $this->belongsTo(Permittion::class, 'permittionId');
    }
}
