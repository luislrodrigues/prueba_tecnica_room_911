<?php

namespace App\Models;

use Carbon\Carbon;
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


    //RELATIONS

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function entries(){
        return $this->hasMany(Entry::class);
    }

    //SCOPE

    public function scopeSearch($query, $search)
    {
        return $query->where('first_name', 'like', '%' . $search . '%')
        ->orWhere('last_name', 'like', '%' . $search . '%')
        ->orWhere('id', 'like', '%' . $search . '%');
    }

    public function scopeDepartmentFilter($query, $departament_id)
    {
        return $query->where('department_id', $departament_id);
    }

    public function scopeHandleAll($query)
    {
        return $query->where('id', '>', 0);
    }

  

   //  ACCESSORS

   public function getFirstNameAttribute($value) {
        return ucfirst($value);
    }   

    public function getLastNameAttribute($value) {
        return ucfirst($value);
    }

    public function getFullNameAttribute() {
        return $this->first_name.' '.$this->last_name;
    }

    public function getLastEntryAttribute()
    {
        $entry = Entry::where('employee_id', $this->id)->where('entry_action', 'YES')->get()->last();
        if ($entry) {
            return Carbon::parse($entry['created_at'])->format('M d Y h:i:s A');
        }
        return 'there is no record';
    }

    public function getLastEntryTotalAttribute()
    {
        return Entry::where('employee_id', $this->id)->where('entry_action', 'YES')->count();
    }

}
