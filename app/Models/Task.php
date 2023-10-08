<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'priority'];
    public $incrementing = false;

    public function getNextPriority()
    {
        $latestTask = self::latest('priority')->first();
        return $latestTask ? $latestTask->priority + 1 : 1;
    }
}
