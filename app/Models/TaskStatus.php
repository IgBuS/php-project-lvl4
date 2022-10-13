<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    public static function getNames()
    {
        $statuses = [
            "новый",
            "в работе",
            "на тестировании",
            "завершен"
        ];
        return $statuses;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'status_id');
    }
}
