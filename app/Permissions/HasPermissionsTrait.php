<?php

namespace App\Permissions;

use App\Models\Permission;
use App\Models\Role;
use App\Models\UserDepartment;
use App\Models\UserDepartmentFields;

trait HasPermissionsTrait
{

  public function givePermissionsTo(...$permissions)
  {

    $permissions = $this->getAllPermissions($permissions);
    if ($permissions === null) {
      return $this;
    }
    $this->permissions()->saveMany($permissions);
    return $this;
  }

  public function withdrawPermissionsTo(...$permissions)
  {

    $permissions = $this->getAllPermissions($permissions);
    $this->permissions()->detach($permissions);
    return $this;
  }

  public function refreshPermissions(...$permissions)
  {

    $this->permissions()->detach();
    return $this->givePermissionsTo($permissions);
  }

  public function hasPermissionTo($permission)
  {
    return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
  }

  public function hasPermissionThroughRole($permission)
  {
    $perm = Permission::where('slug',$permission)->first();
    if($perm){
      foreach ($perm->roles as $role) {
        if ($this->roles->contains($role)) {
          return true;
        }
      }
    }
    return false;
  }

  public function hasRole(...$roles)
  {

    foreach ($roles as $role) {
      if ($this->roles->contains('slug', $role)) {
        return true;
      }
    }
    return false;
  }

  public function roles()
  {

    return $this->belongsToMany(Role::class, 'users_roles');
  }
  public function permissions()
  {

    return $this->belongsToMany(Permission::class, 'users_permissions');
  }
  public function user_departments()
  {

    return $this->belongsToMany(UserDepartment::class, 'user_department_ids');
  }
  protected function hasPermission($permission)
  {
    $perm = Permission::where('slug',$permission)->first();
    $slug='';
    if($perm) $slug = $perm->slug;
    return (bool) $this->permissions->where('slug', $slug)->count();
  }
  public function user_department_fields()
  {

    return $this->belongsToMany(UserDepartmentFields::class, 'user_department_ids_and_field_names');
  }
  protected function hasPermissionToFieldName($department)
  {

    return (bool) $this->user_departments->where('department_id', $department->id)->count();
  }

  public function hasPermissionToFieldNameThroughRole($role)
  {

    foreach ($role->user_department_fields as $field_name) {
      if ($this->user_department_fields->contains($field_name)) {
        return true;
      }
    }
    return false;
  }

  protected function getAllPermissions(array $permissions)
  {

    return Permission::whereIn('slug', $permissions)->get();
  }
}
