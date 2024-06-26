<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'deadline',
        'file_paths' => 'array',       
         'subject',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'deadline' => 'datetime',
    ];

    public function subject()
{
    return $this->belongsTo(Subject::class);
}

// public function students()
// {
//     return $this->belongsToMany(Student::class, 'assignment_student')
//                 ->withPivot('submitted', 'file_path','created_at');
// }

public function students()
{
    return $this->belongsToMany(User::class, 'assignment_student', 'assignment_id', 'student_id')
                ->withPivot('submitted', 'file_path');
}

public function getSubmittedUsersAttribute()
{
    return $this->students()
                ->wherePivot('submitted', true)
                ->get();
}

}
