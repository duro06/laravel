<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    // tabel nya
    protected $table = 'members';
    protected $guarded = [];

    protected $attributes = [
        'image' => null,
        'id_kelompok'=>null
    ];

    // public function members(){
    //     return $this->hasMany('App\Members');
    // }
}
