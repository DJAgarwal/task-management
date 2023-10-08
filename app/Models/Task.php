<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'priority','project_id'];
    public $incrementing = false;

    public function getNextPriority()
    {
        $latestTask = self::latest('priority')->first();
        return $latestTask ? $latestTask->priority + 1 : 1;
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }      
}
