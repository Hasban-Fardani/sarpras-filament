<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(SubmissionItemDetail::class);
    }

    public function division()
    {
        return $this->belongsTo(Employee::class, 'division_id');
    }
}
