<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    protected $fillable = ['name'];
    use HasFactory;

    static function getNames()
    {
        $statuses = [
            "новый", 
            "в работе",
            "на тестировании",
            "завершен"
        ];
        return $statuses;
    }
}
