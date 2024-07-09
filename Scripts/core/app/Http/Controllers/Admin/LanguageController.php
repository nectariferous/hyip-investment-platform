<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\DB;

class LanguageController extends Controller
{
    public function index()
    {
        $data['pageTitle'] = "Language Settings";
        $data['navManageLanguageActiveClass'] = 'active';
        $data['subNavManageLanguageActiveClass'] = 'active';
        $data['languages'] = Language::latest()->get();
        return view('backend.language.index')->with($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'language' => 'required|unique:languages,name',
            'short_code' => 'required|unique:languages,short_code',
        ]);

        $laguage = Language::first();

        if($laguage){
            $is_default = 0;
        }else{
            $is_default = 1;
        }

        Language::create([
            'name'=> $request->language,
            'short_code' => $request->short_code,
            'is_default' => $is_default
        ]);


        $path = resource_path('lang/');

        fopen($path."$request->short_code.json", "w");

        file_put_contents($path."$request->short_code.json",'{}');

        return back()->with('success','Language Created Successfully');
    }

    public function update(Request $request)
    {
        $language = Language::findOrFail($request->id);

        $request->validate([
            'language' => 'required|unique:languages,name,'.$language->id,
            'short_code' => 'required|unique:languages,short_code,'.$language->id,
            'is_default' => 'integer|in:0,1'
        ]);

        if($request->is_default){
            $language->is_default = $request->is_default;
            $language->save();

            DB::table('languages')->where('id','!=',$language->id)->update(['is_default' => 0]);
        }

        $language->update([
            'name'=> $request->language,
            'short_code' => $request->short_code
        ]);

        $path = resource_path()."/lang/$language->short_code.json";


        if(file_exists($path)){

            $file_data = json_encode(file_get_contents($path));

            unlink($path);

            file_put_contents($path,json_decode($file_data));
        }else{

            fopen(resource_path()."/lang/$request->short_code.json", "w");

            file_put_contents(resource_path()."/lang/$request->short_code.json", '{}');
        }

        return back()->with('success','Language Updated Successfully');



    }

    public function delete(Request $request)
    {
        $language = Language::findOrFail($request->id);

        if($language->is_default){
            $notify[] = ['error','Default Language Can not Deleted'];
            return back()->withNotify($notify);
        }

        $path = resource_path()."/lang/$language->short_code.json";

        if(file_exists($path)){
            @unlink($path);
        }

        $language->delete();

        return back()->with('success','Language Deleted Successfully');
    }


    public function transalate(Request $request)
    {
       $pageTitle = "Language Translator";

       $languages = Language::where('short_code','!=',$request->lang)->get();

       $language = Language::where('short_code', $request->lang)->firstOrFail();

       $translators = json_decode(file_get_contents(resource_path()."/lang/$language->short_code.json"),true);

       return view('backend.language.translate',compact('translators','languages'));
    }




    public function transalateUpate(Request $request)
    {
        $language = Language::where('short_code', $request->lang)->firstOrFail();

        $translator = array_filter(array_combine($request->key??[],$request->value??[]));

        file_put_contents(resource_path()."/lang/$language->short_code.json",json_encode($translator));

        return redirect()->route('admin.language.translator',$request->lang)->with('success',__('Translation Updated Suceesfully'));
    }

    public function import(Request $request)
    {
        $language = Language::where('short_code', $request->import)->firstOrFail();


        $currentLang = Language::where('short_code', $request->current)->firstOrFail();


        $contents = file_get_contents(resource_path()."/lang/$language->short_code.json");

        file_put_contents(resource_path()."/lang/$currentLang->short_code.json",$contents);

    }

    public function changeLang(Request $request)
    {
        App::setLocale($request->lang);

        session()->put('locale', $request->lang);

        return redirect()->back()->with('success',__('Successfully Changed Language'));
    }
}
