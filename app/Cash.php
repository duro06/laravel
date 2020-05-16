<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    //tabelnya
    protected $table = 'cash_flow';
    protected $guarded = [];

    // public function cash(){
    //     return $this->hasMany('App\Cash');
    // }
}
