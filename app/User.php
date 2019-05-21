<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable=['f_name','l_name','phone','active'];
    public function hosted(){
        return $this->hasMany('App\Event','host','id');
    }
    public function participates()
    {
        return $this->belongsToMany('App\Event');
    }
    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }
    public function messages()
    {
        return $this->hasMany('App\Message');
    }
}
