<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function emailConfig()
    {
        $data['pageTitle'] = 'Email Configuration';
        $data['navEmailManagerActiveClass'] = 'active';
        $data['subNavEmailConfigActiveClass'] = 'active';

        return view('backend.email.config')->with($data);
    }

    public function emailConfigUpdate(Request $request)
    {

        $data = $request->validate([
            'site_email' => 'required|email',
            'email_method' => 'required',
            'email_config' => "required_if:email_method,==,smtp",
            'email_config.*' => 'required_if:email_method,==,smtp'
        ]);

        $general = GeneralSetting::first();

        $general->update($data);

        $notify[] = ['success', "Email Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);

    }

    public function emailTemplates()
    {
        $data['pageTitle'] = 'Email Templates';
        $data['navEmailManagerActiveClass'] = 'active';
        $data['subNavEmailTemplatesActiveClass'] = 'active';

        $data['emailTemplates'] = EmailTemplate::latest()->paginate();

        return view('backend.email.templates')->with($data);
    }

    public function emailTemplatesEdit (EmailTemplate $template)
    {
        $pageTitle = 'Template Edit';

        return view('backend.email.edit',compact('pageTitle','template'));
    }

    public function emailTemplatesUpdate(Request $request, EmailTemplate $template)
    {
        $data = $request->validate([
            'subject' => 'required',
            'template' => 'required',
        ]);

        $template->update($data);


        $notify[] = ['success', "Email Template Updated Successfully"];

        return redirect()->back()->withNotify($notify);

    }
}
