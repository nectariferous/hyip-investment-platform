<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $data['pageTitle'] = 'Manage Roles';

        $data['permissions'] = Permission::latest()->get();

        $data['roles'] = Role::where('name','!=','admin')->latest()->paginate();


        return view('backend.role.index')->with($data); 
    }

    public function store (Request $request)
    {
        $request->validate([
            'role' => 'required|max:100|unique:roles,name',
            'permission' => 'required|array'
        ]);


        $role = Role::create(['name' => $request->role, 'guard_name' => 'admin']);

           
        $role->givePermissionTo($request->permission);


        return redirect()->back()->with('success','Successfully Create Role');
    }


    public function update( Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'role' => 'required|max:100|unique:roles,name,'.$role->id,
            'permission' => 'required|array'
        ]);


        $role->update(['name' => $request->role]);

        $role->syncPermissions($request->permission);

        return redirect()->back()->with('success','Successfully Updated Role');

    }

    public function edit()
    {
        abort(404);
    }

    public function show()
    {
        abort(404);
    }

    public function destroy()
    {
        abort(404);
    }
}
