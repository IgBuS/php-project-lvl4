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
        'assigned_to_id',
        'labels'
    ];

    public function getid()
    {
        return $this->id;
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function labelsIds()
    {
        return $this->belongsToMany(Label::class)->pluck('labels.id')->toArray();
    }

    public function labelsNames()
    {
        return $this->belongsToMany(Label::class)->pluck('labels.name')->toArray();
    }
}
