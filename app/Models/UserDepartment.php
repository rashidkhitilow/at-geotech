<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    use HasFactory;
    protected $table = 'user_department_ids';
    public function user_department_fields()
    {
        return $this->hasMany(UserDepartmentFields::class, 'user_department_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
