<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserJob extends Model
{
    protected $table = 'tbluserjob2';
    protected $primaryKey = 'jobid';
    public $timestamps = true; 
    protected $fillable = ['job_title', 'job_description']; 

    public function users()
    {
        return $this->hasMany(User::class, 'jobid');
    }
}