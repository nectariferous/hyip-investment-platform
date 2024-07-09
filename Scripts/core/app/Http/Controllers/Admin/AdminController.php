<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    public function profile()
    {
        $pageTitle = 'Profile';

        return view('backend.profile', compact('pageTitle'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'username' => 'required',
            'image' => 'sometimes|image|mimes:jpg,jpeg,png'
        ]);

        $admin = auth()->guard('admin')->user();

        if ($request->has('image')) {

            $path = filePath('admin');

            $size = '200x200';

            $filename = uploadImage($request->image, $path, $size, $admin->image);

            $admin->image = $filename;
        }


        $admin->email = $request->email;
        $admin->username = $request->username;
        $admin->save();

        $notify[] = ['success', 'Admin Profile Update Success'];

        return redirect()->back()->withNotify($notify);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $admin = auth()->guard('admin')->user();

        if (!Hash::check($request->old_password, $admin->password)) {
            $notify[] = ['error', 'Password Does not match'];

            return back()->withNotify($notify);
        }

        $admin->password = bcrypt($request->password);
        $admin->save();


        $notify[] = ['success', 'Password changed Successfully'];

        return back()->withNotify($notify);
    }


    public function index()
    {
        $data['pageTitle'] = 'Manage Admins';

        $data['admins'] = Admin::where('username', '!=', 'admin')->latest()->paginate();

        return view('backend.admins.index')->with($data);
    }


    public function create()
    {
        $data['pageTitle'] =  'Create Admins';


        $data['roles'] = Role::latest()->get();


        return view('backend.admins.create')->with($data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:admins,username',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
            'roles' => 'required|array',
            'admin_image' => 'nullable|mimes:jpg,png,jpeg'
        ]);


        $admin =  Admin::create([
            'name' => $request->username,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image' => $request->has('admin_image') ? uploadImage($request->admin_image, filePath('admins')) : ''
        ]);


        $admin->assignRole($request->roles);

        return redirect()->back()->with('success', 'Admin created Successfully');
    }

    public function edit($id)
    {
        $data['admin'] = Admin::where('username', '!=', 'admin')->findOrFail($id);


        $data['pageTitle'] =  'Create Admins';


        $data['roles'] = Role::latest()->get();

        return view('backend.admins.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::where('username', '!=', 'admin')->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:admins,username,' . $admin->id,
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
            'roles' => 'required|array',
            'admin_image' => 'nullable|mimes:jpg,png,jpeg'
        ]);



        $admin->update([
            'name' => $request->username,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password != null ?  bcrypt($request->password) : $admin->password,
            'image' => $request->has('admin_image') ? uploadImage($request->admin_image, filePath('admins')) : $admin->image
        ]);


        $admin->syncRoles($request->roles);


        return redirect()->back()->with('success', 'Successfully updated Admins');
    }


    public function tableFilter(Request $request)
    {

        if ($request['type'] === 'text') {
            $table =  ($request['model'] === 'Role' ?  '\Spatie\Permission\Models\Role' : '\\App\\Models\\' . $request['model'])::where($request['colum'], 'LIKE', '%' . $request['val'] . '%');

            if ($request['model'] === 'Role') {
                $table->where('name', '!=', 'Admin');
            }
        } elseif ($request['type'] === 'date') {
            $table =  ($request['model'] === 'Role' ?  '\Spatie\Permission\Models\Role' : '\\App\\Models\\' . $request['model'])::where($request['colum'], $request['val']);
        } elseif ($request['type'] === 'select') {
            $table =  ($request['model'] === 'Role' ?  '\Spatie\Permission\Models\Role' : '\\App\\Models\\' . $request['model'])::where($request['colum'], $request['val']);
        }


        $tables = $table->get();

        $type = $request['model'];


        return view('backend.filter_view', compact('tables', 'type'));
    }
}
