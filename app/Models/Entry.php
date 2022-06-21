<?php

namespace App\Models;

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

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
