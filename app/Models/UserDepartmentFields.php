<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDepartmentFields extends Model
{
    use HasFactory;
    protected $table = 'user_department_ids_and_field_names';

    public function user_department()
    {
        return $this->belongsTo(UserDepartment::class, 'user_department_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function getFieldNamesFromUserByDepartmentId($department_id){
        $field_names = UserDepartmentFields::where('user_id', auth()->user()->id)
        ->whereIn('user_department_id', function ($q) use ($department_id) {
            $q->select('id')->from('user_department_ids')
                ->whereRaw('user_department_ids.id = user_department_ids_and_field_names.user_department_id')
                ->where('user_department_ids.department_id', $department_id);
        })
        ->pluck('field_name')
        ->toArray();

        return $field_names;
    }
}
