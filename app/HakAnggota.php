<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HakAnggota extends Model
{
    //
    use SoftDeletes;
    
    protected $table = 'hak_anggota';
    protected $guarded = [];
    protected $dates=['deleted_at'];
}
