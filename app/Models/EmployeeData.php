<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeData extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'employee_datas';
    public static $PERMISSION_NAME = 'employee_datas';
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $dates = ['created_at', 'updated_at'];

    public function getTableColumns()
    {
        $arr = collect(self::first())->keys();
        $selected = $arr->filter(function($value, $key) {
            return !in_array($value,['user_id','created_at','updated_at','deleted_at']);
        })->toArray();
        $arr = [];
        foreach($selected as $key=>$value){
            $arr[$value] = $this->$value;
        }
        return $arr;
    }
}
