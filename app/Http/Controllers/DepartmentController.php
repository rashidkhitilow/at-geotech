<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\UserDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function autocomplete(Request $req) {
        // if (!Auth::user()->can(Department::$PERMISSION_NAME.'-view')) return response(['result' => 'fail','message' => 'Permission denied'], 401);
        $term = $req->input('term')??'';
        $page = $req->page??1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;
        $term = $req->input('term')??'';
        $user_department_ids = UserDepartment::where('user_id', auth()->user()->id)
        ->pluck('department_id')
        ->toArray();
        if($term != '') {
            $a = Department::where('title', 'like', '%'.$term.'%')
            ->whereIn('id',$user_department_ids);
            return $a
                    ->offset($offset)
                    ->limit($per_page)
                    ->get()
                    ->map(function ($item){
                                return [
                                            'label' => $item->title,
                                            'text' => $item->title,
                                            'value' => $item->title,
                                            'id' => $item->id
                                    ];
                            });
        } else {
            return [];
        }
    }
}
