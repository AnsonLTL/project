<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    //currently used because of dummy data's MassAssignment
    protected $fillable = [
        'company_id',
        'code',
        'parent',
        'label',
        'description',
        'crdr'
    ];
    public function parent() {
        return $this->belongsTo('Coa', 'parent');
    }
    public function children() {
        return $this->hasMany('Coa', 'parent');
    }
}
