<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'entries';

    protected $fillable = [
        'employee_id',
        'document_number',
        'entry_action'
    ];
    

    //RELATIONS 
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    //SCOPE

    public function scopeGetEntryEmployee($query, $id){
        return $query->where('employee_id', $id);
    }

    public function scopeDateEntry($query, $date_from, $date_to)
    {
        return $query->whereDate('created_at', '>=', $date_from)
            ->whereDate('created_at', '<=', $date_to);
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('M d Y h:i:s A');
    }
  

}
