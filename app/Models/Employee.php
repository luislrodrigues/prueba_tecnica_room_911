<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'employees';

    protected $fillable = [
        'department_id',
        'first_name',
        'last_name',
        'email',
        'document_number',
        'status'
    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function entries(){
        return $this->hasMany(Entry::class);
    }


    public function scopeSearch($query, $search)
    {
        return $query->where('first_name','like', '%'.$search.'%')
                        ->orWhere('last_name','like', '%'.$search.'%')
                        ->orWhere('id','like', '%'.$search.'%');
    }

    public function scopeDepartmentFilter($query, $departament_id){
        return $query->where('department_id', $departament_id);
    }

    public function scopeHandleAll($query){
        return $query->where('id', '>', 0);

    }
}
