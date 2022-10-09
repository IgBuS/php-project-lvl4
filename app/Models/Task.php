<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'status_id',
        'assigned_to_id'
    ];

    public function getid()
    {
        return $this->id;
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function assigned_to()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }
}
