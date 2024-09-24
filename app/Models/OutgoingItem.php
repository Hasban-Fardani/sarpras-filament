<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function operator()
    {
        return $this->belongsTo(Employee::class, 'operator_id');
    }

    public function division()
    {
        return $this->belongsTo(Employee::class, 'division_id');
    }
}
