<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['id','content','status'];
    
    public function users()
    {
 
     return $this->belongsTO(User :: class);
 }

}
