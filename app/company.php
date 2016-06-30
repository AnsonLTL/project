<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    //
    public function users() {
        return $this->belongsToMany('App\User', 'company_user', 'co_id', 'user_id');
    }
}
