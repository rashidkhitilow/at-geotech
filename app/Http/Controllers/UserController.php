<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDepartment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $req)
    {
        $all = $this->all($req);
        $mode = 'all';
        $departments = Department::all();
        return view('users.index', compact('all', 'mode', 'departments'));
    }
    public function filter(Request $req)
    {
        $all = $this->all($req);
        return view('users.tbl', compact('all'));
    }
    public function all(Request $req)
    {
        // MyUtils::dbEnableLog();

        $page = $req->input('page', 1);
        $per_page = 50;
        $offset = ($page - 1) * $per_page;
        $pages = 0;


        $items =  User::leftJoin('users_roles', 'users_roles.user_id', '=', 'users.id')
        ->leftJoin('roles', 'roles.id', '=', 'users_roles.role_id');


        if ($req->input('ff__id') != '') $items = $items->where('users.id', $req->input('ff__id'));
        if ($req->input('ff__name') != '') $items = $items->where('users.name', $req->input('ff__name'));

        $items = $items->select(
            'users.*',
            'roles.name as role',
            'roles.name as role',
        );

        $items = $items->orderBy('users.id', 'desc');
        $items = $items->offset($offset)
                        ->limit($per_page)
                        ->get()
                        ->map(function ($item){
                            $departments =  $item->user_departments->map(function($e) { return [
                                'title' => Department::find($e->department_id)->title,
                            ];
                            })->toArray();
                            $user_departments="";
                            foreach ($departments as $department){
                                $user_departments .= $department['title'].', ';
                            }
                            $user_departments = rtrim($user_departments,', ');
                            $user_department_fields =  $item->user_department_fields->map(function($e) { 
                                $user_dept = UserDepartment::find($e->user_department_id);
                                $department=Department::find($user_dept->department_id);
                                return [
                                'name' => $department->title.'-'.$e->field_name,
                                ];
                            })->toArray();
                            $user_department_field_names="";
                            foreach ($user_department_fields as $department){
                                $user_department_field_names .= $department['name'].', ';
                            }
                            $user_department_field_names = rtrim($user_department_field_names,', ');

                            return [
                                        'id' => $item->id,
                                        'name' => $item->name,
                                        'email' => $item->email,
                                        'phone_number' => $item->phone_number,
                                        'user_departments' => $user_departments,
                                        'user_department_field_names' => $user_department_field_names,
                                        'role' => $item->role,
                                        'created_at' => $item->created_at->format('d.m.Y'),
                                        'handled_by' => $item->user,
                                ];
                        })
                        ;
        // dd(MyUtils::dbLog());
        return compact('per_page', 'page', 'offset', 'items', 'pages');
    }
    public function save(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'role_id' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $user = User::findOrFail($req->id);
            $user->name = $req->name;
            $user->save();
            DB::table('users_roles')->where('user_id', $user->id)->delete();
            $role = Role::find($req->role_id);
            $user->roles()->attach($role);
            $item = $user;
            DB::commit();
            $result = 'success';
            $message = 'User was successfully updated!';
            return compact('result', 'message', 'item', 'user');
        } catch(Exception $e) {
            DB::rollBack();
            $result = 'fail';
            $message = $e->getMessage();
            return compact('result', 'message');
        }
    }
    public function new(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required',
            'departments' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $req->name;
            $user->email = $req->email;
            $user->phone_number = $req->phone_number;
            $user->password = Hash::make($req->password);
            $user->save();
            $id = $user->id;
            if ($id != '') {
                if (!empty($req->departments)) {
                    for ($i = 0; $i < count($req->departments); $i++) {
                        DB::table('user_department_ids')->insert([
                            'user_id' => $id,
                            'department_id' => $req->departments[$i],
                        ]);
                    }
                }
            }
            $role = Role::find($req->role_id);
            $user->roles()->attach($role);
            $item = $user;
            DB::commit();
            $result = 'success';
            $message = 'User was successfully created!';
            return compact('result', 'message', 'item', 'user');
        } catch(Exception $e) {
            DB::rollBack();
            $result = 'fail';
            $message = $e->getMessage();
            return compact('result', 'message');
        }
    }

    public function remove(Request $req)
    {
        DB::beginTransaction();
        try {

            $item = User::findOrFail($req->id);
            DB::table('user_department_ids')->where('user_id', $item->id)->delete();
            DB::table('users_roles')->where('user_id', $item->id)->delete();
            $item->delete();
            DB::commit();
            $result = 'success';
            return compact('result');
        } catch(Exception $e) {
            DB::rollBack();
            $result = 'fail';
            $message = $e->getMessage();
            return compact('result', 'message');
        }
    }


    public function autocomplete(Request $req)
    {
        $term = $req->input('term') ?? '';
        $page = $req->page ?? 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;
        if ($term) {
            // DB::connection()->enableQueryLog();
            $a = User::where('id', 'like', '%' . $term . '%')
                ->offset($offset)
                ->limit($per_page)
                ->orderBy('id')
                ->get()
                ->map(function ($item) {
                    $label = $item->name;
                    return [
                        'value' => $label,
                        'id' => $item->id,
                        'text' => $label,
                        'label' => $label,
                        'title' => $item->name,
                    ];
                });
            // dd(DB::getQueryLog());
            return $a;
        } else {
            return [];
        }
    }
}
