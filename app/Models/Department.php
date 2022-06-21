<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'departments';

    const DEPARTMENTS = [
        'Departament 1',
        'Department 2'
    ];

    protected $fillable = [
        'name',
        'status'
    ];

    public function employees(){
        return $this->hasMany(Employee::class);
    }
}
