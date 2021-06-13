<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\EmployeeData;
use App\Models\Position;
use App\Models\UserDepartmentFields;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkFieldName', ['only' => [
            'update',
            'add',
            'new',
            'edit'
        ]]);
    }
    public function index(Request $req)
    {
        if (!auth()->user()->hasPermissionTo('show-'.EmployeeData::$PERMISSION_NAME)) return ['result' => 'fail','message' => 'Permission denied'];
        $all = $this->all($req);
        $mode = 'all';
        $departments = Department::all();
        $positions = Position::all();
        return view('employee_datas.index', compact('all', 'mode', 'departments', 'positions'));
    }
    public function filter(Request $req)
    {
        $all = $this->all($req);
        return view('employee_datas.tbl', compact('all'));
    }
    public function all(Request $req)
    {
        $page = $req->input('page', 1);
        $per_page = 50;
        $offset = ($page - 1) * $per_page;
        $pages = 0;
        $items =  EmployeeData::leftJoin('departments', 'departments.id', '=', 'employee_datas.department_id')
            ->leftJoin('positions', 'positions.id', '=', 'employee_datas.position_id')
            ->leftJoin('users', 'users.id', '=', 'employee_datas.user_id');

        if ($req->input('ff__id') != '') $items = $items->where('employee_datas.id', 'like', '%'.$req->input('ff__id').'%');
        if ($req->input('ff__name') != '') $items = $items->where('employee_datas.name', 'like', '%'.$req->input('ff__name').'%');
        if ($req->input('ff__surname') != '') $items = $items->where('employee_datas.surname', 'like', '%'.$req->input('ff__surname').'%');

        $items = $items->select(
            'employee_datas.*',
            'positions.title as position_id',
            'departments.title as department_id',
            'users.id as user_id',
            'users.name as user',
        );

        $items = $items->orderBy('employee_datas.id', 'desc');
        $items = $items->offset($offset)
            ->limit($per_page)
            ->get()
            ->map(function ($item) {
                $field_names = UserDepartmentFields::getFieldNamesFromUserByDepartmentId($item['department_id']);
                $columns = $item->getTableColumns();
                $name=null;
                $surname=null;
                $address=null;
                $phone=null;
                $position_id=null;
                $department_id=null;
                foreach($columns as $key=>$value){
                    $$key= ($item['user_id'] == auth()->user()->id ? $item->$key : (in_array($key, $field_names) ? $item->$key : '<i class="fas fa-lock"></i>'));
                }
                return [
                    'id' => $id,
                    'name' => $name,
                    'surname' => $surname,
                    'address' => $address,
                    'phone' => $phone,
                    'position' => $position_id,
                    'department' => $department_id,
                    'created_at' => $item->created_at->format('d.m.Y'),
                    'user_id' => $item->user_id,
                    'handled_by' => $item->user,
                ];
            });
        return compact('per_page', 'page', 'offset', 'items', 'pages');
    }
    public function save(Request $req)
    {
        if (!auth()->user()->hasPermissionTo('edit-'.EmployeeData::$PERMISSION_NAME)) return ['result' => 'fail','message' => 'Permission denied'];
        $req->validate([
            'name' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $employee_data = EmployeeData::findOrFail($req->id);
            $employee_data->name = $req->name;
            $employee_data->surname = $req->surname;
            if (isset($req->department_id)) {
                $employee_data->department_id = $req->department_id;
            }
            $employee_data->save();
            $item = $employee_data;
            DB::commit();
            $result = 'success';
            $message = 'EmployeeData was successfully updated!';
            return compact('result', 'message', 'employee_data');
        } catch (Exception $e) {
            DB::rollBack();
            $result = 'fail';
            $message = $e->getMessage();
            return compact('result', 'message');
        }
    }
    public function new(Request $req)
    {
        if (!auth()->user()->hasPermissionTo('add-'.EmployeeData::$PERMISSION_NAME)) return ['result' => 'fail','message' => 'Permission denied'];
        $req->validate([
            'name' => 'required',
            'department_id' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $employee_data = new EmployeeData();
            $employee_data->name = $req->name;
            $employee_data->surname = $req->surname;
            $employee_data->phone = $req->phone;
            $employee_data->address = $req->address;
            $employee_data->position_id = $req->position_id;
            $employee_data->department_id = $req->department_id;
            $employee_data->save();
            $item = $employee_data;
            DB::commit();
            $result = 'success';
            $message = 'EmployeeData was successfully created!';
            return compact('result', 'message', 'employee_data');
        } catch (Exception $e) {
            DB::rollBack();
            $result = 'fail';
            $message = $e->getMessage();
            return compact('result', 'message');
        }
    }

    public function remove(Request $req)
    {
        if (!auth()->user()->hasPermissionTo('delete-'.EmployeeData::$PERMISSION_NAME)) return ['result' => 'fail','message' => 'Permission denied'];
        DB::beginTransaction();
        try {

            $item = EmployeeData::findOrFail($req->id);
            $item->delete();
            DB::commit();
            $result = 'success';
            return compact('result');
        } catch (Exception $e) {
            DB::rollBack();
            $result = 'fail';
            $message = $e->getMessage();
            return compact('result', 'message');
        }
    }

// for select if needed
    public function autocomplete(Request $req)
    {
        $term = $req->input('term') ?? '';
        $page = $req->page ?? 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;
        if ($term) {
            // DB::connection()->enableQueryLog();
            $a = EmployeeData::where('id', 'like', '%' . $term . '%')
                ->offset($offset)
                ->limit($per_page)
                ->orderBy('id')
                ->get()
                ->map(function ($item) {
                    $label = $item->name . ' ' . $item->surname;
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


    // API's


    public function list(Request $req)
    {
        if (!auth()->user()->hasPermissionTo('show-'.EmployeeData::$PERMISSION_NAME)) return ['result' => 'fail','message' => 'Permission denied'];
        $page = $req->input('page', 1);
        $next_page = $page + 1;
        $per_page = 50;
        $offset = ($page - 1) * $per_page;
        $pages = 0;

        $items =  EmployeeData::leftJoin('departments', 'departments.id', '=', 'employee_datas.department_id')
            ->leftJoin('positions', 'positions.id', '=', 'employee_datas.position_id')
            ->leftJoin('users', 'users.id', '=', 'employee_datas.user_id');

        if ($req->input('ff__id') != '') $items = $items->where('employee_datas.id', $req->input('ff__id'));
        if ($req->input('ff__name') != '') $items = $items->where('employee_datas.name', $req->input('ff__name'));
        $items = $items->select(
            'employee_datas.*',
            'positions.title as position_id',
            'departments.title as department_id',
            'users.name as user',
        );
        $items = $items->orderByDesc('employee_datas.id');

        $items = $items->offset($offset)->limit($per_page)->get()->map(function ($item) {
            $field_names = UserDepartmentFields::getFieldNamesFromUserByDepartmentId($item['department_id']);
            $columns = $item->getTableColumns();
            $name=null;
            $surname=null;
            $address=null;
            $phone=null;
            $position_id=null;
            $department_id=null;
            foreach($columns as $key=>$value){
                $$key= ($item['user_id'] == auth()->user()->id ? $item->$key : (in_array($key, $field_names) ? $item->$key : '<i class="fas fa-lock"></i>'));
            }
            return [
                'id' => $id,
                'name' => $name,
                'surname' => $surname,
                'address' => $address,
                'phone' => $phone,
                'position' => $position_id,
                'department' => $department_id,
                'created_at' => $item->created_at->format('d.m.Y'),
                'handled_by' => $item->user,
            ];
        });
        $result = 'success';
        $message = 'Request was successfull!';
        return compact('result', 'message', 'per_page', 'page', 'offset', 'items', 'next_page');
    }

    public function add(Request $req)
    {
        if (!auth()->user()->hasPermissionTo('add-'.EmployeeData::$PERMISSION_NAME)) return ['result' => 'fail','message' => 'Permission denied'];
        $validator = Validator::make($req->all(),[
            'name' => 'required',
            'department_id' => 'required',
        ]);
        if ($validator->fails()) {
            return ['result' => 'fail','message' => $validator->messages()];
        }
        DB::beginTransaction();
        try {
            $employee_data = new EmployeeData();
            $employee_data->name = $req->name;
            $employee_data->surname = $req->surname;
            $employee_data->phone = $req->phone;
            $employee_data->address = $req->address;
            $employee_data->position_id = $req->position_id;
            $employee_data->department_id = $req->department_id;
            $employee_data->save();
            $item = $employee_data;
            DB::commit();
            $result = 'success';
            $message = 'EmployeeData was successfully created!';
            return compact('result', 'message', 'employee_data');
        } catch (Exception $e) {
            DB::rollBack();
            $result = 'fail';
            $message = $e->getMessage();
            return compact('result', 'message');
        }
    }


    public function update(Request $req)
    {
        if (!auth()->user()->hasPermissionTo('edit-'.EmployeeData::$PERMISSION_NAME)) return ['result' => 'fail','message' => 'Permission denied'];
        $validator = Validator::make($req->all(),[
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return ['result' => 'fail','message' => $validator->messages()];
        }
        DB::beginTransaction();
        try {
            $employee_data = EmployeeData::findOrFail($req->id);
            if (!$employee_data) {
                $result = 'fail';
                $message = 'Invalid Employee data id!';
                return response(compact('result', 'message'));
            }
            $employee_data->name = $req->name;
            $employee_data->surname = $req->surname;
            if (isset($req->department_id)) {
                $employee_data->department_id = $req->department_id;
            }
            $employee_data->save();
            DB::commit();
            $result = 'success';
            $message = 'EmployeeData was successfully updated!';
            return compact('result', 'message', 'employee_data');
        } catch (Exception $e) {
            DB::rollBack();
            $result = 'fail';
            $message = $e->getMessage();
            return compact('result', 'message');
        }
    }
}
