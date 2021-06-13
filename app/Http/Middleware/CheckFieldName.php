<?php

namespace App\Http\Middleware;

use App\Models\EmployeeData;
use App\Models\UserDepartmentFields;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

class CheckFieldName
{
    private $route;

    public function __construct(RoutingRoute $route) {
    $this->route = $route;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        list(, $action) = explode('@',request()->route()->getActionName());
        if($action == "new" || $action == "add"){
            $field_names = UserDepartmentFields::getFieldNamesFromUserByDepartmentId($request->department_id);
            foreach ($request->except('_token') as $key => $value) {
                if(!in_array($key, $field_names) && $value!='')  return response(['result' => 'fail','message' => 'Permission denied for Department field - '.$key], 401);
            }
        }elseif($action == "save" || $action == "update"){
            $employee_data = EmployeeData::findOrFail($request->id);
            if($employee_data->user_id != $request->user()->id){
                $dept_id = $request->department_id!='' ? $request->department_id : $employee_data['department_id'];
                $field_names = UserDepartmentFields::getFieldNamesFromUserByDepartmentId($dept_id);
                foreach ($request->except('_token') as $key => $value) {
                    if(!in_array($key, $field_names) && $value!='')  return response(['result' => 'fail','message' => 'Permission denied for Department field - '.$key], 401);
                }
            }
        }
        return $next($request);

    }
}
