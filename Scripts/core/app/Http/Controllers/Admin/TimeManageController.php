<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Time;

class TimeManageController extends Controller
{
    
    public function index()
    {
        $pageTitle = 'All Time';

        $times = Time::latest()->paginate();

        return view('backend.timemanagement.index', compact('pageTitle', 'times'));
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:times',
            'time' => 'required',            
        ]);

        Time::create([
            'name' => $request->name,
            'time' => $request->time,          

        ]);

        $notify[] = ['success', 'Time Created Successfully'];

        return redirect()->route('admin.time.index')->withNotify($notify);
    }



    public function update(Request $request,Time $time)
    {      
        
        $request->validate([
            'name' => 'required|unique:times,name,'.$time->id,
            'time' => 'required',      
        ]);      

        $time->update([
            'name' => $request->name,
            'time' => $request->time,           
        ]);

        $notify[] = ['success', 'Time Updated Successfully'];

        return redirect()->route('admin.time.index')->withNotify($notify);
    }


}
