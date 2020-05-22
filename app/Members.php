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
        'kelompok_id'=>null
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    // public function members(){
    //     return $this->hasMany('App\Members');
    // }
}
