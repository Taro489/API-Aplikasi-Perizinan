<?php

namespace App\Models;

use App\Models\User;
use App\Models\AcceptPermittions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permittion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function User(){
        return $this->belongsTo(User::class, 'userId');
    }

    public function AcceptPermittions(){
        return $this->hasOne(AcceptPermittions::class, 'permittionId');
    }
}
