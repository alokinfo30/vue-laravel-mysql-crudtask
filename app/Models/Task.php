<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'attachment',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($task) {
            $validator = Validator::make($task->getAttributes(), [
                'title' => 'required|string|max:255|unique:tasks',
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->messages()->first());
            }
        });
    }
}
