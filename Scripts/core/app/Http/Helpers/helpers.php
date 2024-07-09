<?php

use App\Models\Advertise;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use App\Models\Payment;
use App\Models\Ranking;
use App\Models\Refferal;
use App\Models\RefferedCommission;
use App\Models\SectionData;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\User;

function makeDirectory($path)
{
    if (file_exists($path)) return true;
    return mkdir($path, 0755, true);
}



function removeFile($path)
{
    return file_exists($path) && is_file($path) ? @unlink($path) : false;
}

function fileUpload($file, $location)
{
    $path = makeDirectory($location);

    if (!$path) throw new Exception('File could not been created.');

    if (!empty($old)) {
        removeFile($location . '/' . $old);
        removeFile($location . '/thumb_' . $old);
    }

    $filename = $file->getClientOriginalName();

    $file->move($location, $filename);

    $location = $location . '/' . $filename;

    return $location;
}

function uploadImage($file, $location, $size = null, $old = null, $thumb = null)
{

    $path = makeDirectory($location);

    if (!$path) throw new Exception('File could not been created.');

    if (!empty($old)) {
        removeFile($location . '/' . $old);
        removeFile($location . '/thumb_' . $old);
    }

    $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();


    if ($file->getClientOriginalExtension() == 'gif') {
        copy($file->getRealPath(), $location . '/' . $filename);
    } else {

        $image = Image::make($file);

        if (!empty($size)) {
            $size   = explode('x', strtolower($size));

            $canvas = Image::canvas(400, 400);

            $image = $image->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            });

            $canvas->insert($image, 'center');
            $canvas->save($location . '/' . $filename);
        } else {
            $image->save($location . '/' . $filename);
        }

        if (!empty($thumb)) {
            $thumb = explode('x', $thumb);
            Image::make($file)->resize($thumb[0], $thumb[1])->save($location . '/thumb_' . $filename);
        }
    }

    return $filename;
}





function menuActive($routeName)
{

    $class = 'active';

    if (is_array($routeName)) {
        foreach ($routeName as $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    } elseif (request()->routeIs($routeName)) {
        return $class;
    }
}

function verificationCode($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}

function gatewayImagePath()
{

    $general = GeneralSetting::first();

    return "asset/theme{$general->theme}/images/gateways";
}

function filePath($folder_name)
{
    $general = GeneralSetting::first();

    return "asset/theme{$general->theme}/images/" . $folder_name;
}


function frontendFormatter($key)
{
    return ucwords(str_replace('_', ' ', $key));
}


function getFile($folder_name, $filename)
{
    $general = GeneralSetting::first();

    if (file_exists(filePath($folder_name) . '/' . $filename) && $filename != null) {

        return asset("asset/theme{$general->theme}/images/" . $folder_name . '/' . $filename);
    }

    return asset("asset/theme{$general->theme}/images/placeholder.png");
}

function variableReplacer($code, $value, $template)
{
    return str_replace($code, $value, $template);
}

function sendGeneralMail($data)
{
    $general = GeneralSetting::first();


    if ($general->email_method == 'php') {
        $headers = "From: $general->sitename <$general->site_email> \r\n";
        $headers .= "Reply-To: $general->sitename <$general->site_email> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        @mail($data['email'], $data['subject'], $data['message'], $headers);
    } else {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $general->email_config->smtp_host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $general->email_config->smtp_username;
            $mail->Password   = $general->email_config->smtp_password;
            if ($general->email_config->smtp_encryption == 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }
            $mail->Port       = $general->email_config->smtp_port;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($general->site_email, $general->sitename);
            $mail->addAddress($data['email'], $data['name']);
            $mail->addReplyTo($general->site_email, $general->sitename);
            $mail->isHTML(true);
            $mail->Subject = $data['subject'];
            $mail->Body    = $data['message'];
            $mail->send();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}

function sendMail($key, array $data, $user)
{

    $general = GeneralSetting::first();

    $template =  EmailTemplate::where('name', $key)->first();



    $message = variableReplacer('{username}', $user->username, $template->template);
    $message = variableReplacer('{sent_from}', @$general->sitename, $message);

    foreach ($data as $key => $value) {
        $message = variableReplacer("{" . $key . "}", $value, $message);
    }

    if ($general->email_method == 'php') {
        $headers = "From: $general->sitename <$general->site_email> \r\n";
        $headers .= "Reply-To: $general->sitename <$general->site_email> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        @mail($user->email, $template->subject, $message, $headers);
    } else {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $general->email_config->smtp_host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $general->email_config->smtp_username;
            $mail->Password   = $general->email_config->smtp_password;
            if ($general->email_config->smtp_encryption == 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }
            $mail->Port       = $general->email_config->smtp_port;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($general->site_email, $general->sitename);
            $mail->addAddress($user->email, $user->username);
            $mail->addReplyTo($general->site_email, $general->sitename);
            $mail->isHTML(true);
            $mail->Subject = $template->subject;
            $mail->Body    = $message;
            $mail->send();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
function content($key)
{
    $general = GeneralSetting::first();

    return SectionData::where('theme', $general->theme)->where('key', $key)->first();
}

function element($key, $take = 10)
{
    $general = GeneralSetting::first();

    return SectionData::where('theme', $general->theme)->where('key', $key)->take($take)->get();
}

function template()
{
    $general = GeneralSetting::first();

    if ($general->theme == 1) {
        return 'frontend.';
    } else {
        return "theme{$general->theme}.";
    }
}

function sectionManager()
{
    $general = GeneralSetting::first();

    if ($general->theme == 1) {

        return resource_path('views/') . 'sections.json';
    } else {
        return resource_path('views/theme' . $general->theme . '/') . 'sections.json';
    }
}

function colorText($haystack, $needle)
{
    $replace = "<span>{$needle}</span>";

    return str_replace($needle, $replace, $haystack);
}

function refferMoney($id, $user, $refferal_type, $amount, $plan)
{

    $user_id = $id;

    $level = Refferal::where('status', 1)->where('type', $refferal_type)->where('plan_id', $plan)->first();

    $counter = $level ? count($level->level) : 0;

    $general = GeneralSetting::first();

    for ($i = 0; $i < $counter; $i++) {

        if ($user) {

            $comission = ($level->commision[$i] * $amount) / 100;
            $user->balance = $user->balance + $comission;

            $user->save();

            $a = RefferedCommission::create([
                'reffered_by' => $user->id,
                'reffered_to' => $id,
                'commission_from' => $user_id,
                'amount' => $comission,
                'purpouse' => $refferal_type === 'invest' ? 'Return invest commission' : 'Return Interest Commission'

            ]);

            sendMail('Commission', [
                'refer_user' => $user->username,
                'amount' => $comission,
                'currency' => $general->site_currency,
            ], $user);

            $id = $user->id;
            $user = $user->refferedBy;
        }
    }
}


function advertisements($size)
{
    $ad = Advertise::where('resolution', $size)->where('status', 1)->inRandomOrder()->first();
    if (!empty($ad)) {
        if ($ad->type == 1) {
            return  '<a  target="_blank" href="' . $ad->redirect_url . '"><img src="' . asset('asset/images/advertisement/' . $ad->ad_image) . '" alt="image" class="w-100"></a>';
        }
        if ($ad->type == 2) {
            return $ad->script;
        }
    } else {
        return '';
    }
}


function singleMenu($routeName)
{
    $class = 'active';

    if (request()->routeIs($routeName)) {
        return $class;
    }

    return '';
}

function arrayMenu($routeName)
{
    $class = 'open';
    if (is_array($routeName)) {
        foreach ($routeName as $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    }
}

function filterByVariousType(array $inputs)
{

    $generateHtml = '';

    foreach ($inputs as $key => $input) {

        if ($key === 'model') {

            $generateHtml .= <<<EOD
             <input type="hidden" name="model" class="form-control" value="{$input}" id="model">
            EOD;
        } elseif ($key === 'text') {

            $generateHtml .= <<<EOD
             <input type="text" name="{$input['name']}" placeholder="{$input['placeholder']}" class="form-control w-auto mr-3" id="{$input['id']}" data-colum="{$input['filter_colum']}">
            EOD;
        } elseif ($key === 'date') {
            $generateHtml .= <<<EOD
            <input type="date" name="{$input['name']}" class="form-control w-auto" id="{$input['id']}" data-colum="{$input['filter_colum']}">
           EOD;
        } elseif ($key === 'select') {
            $options = '';

            foreach ($input['options'] as $key => $option) {

                $options .= "<option value=" . $key . ">" . $option . " </option>";
            }

            $generateHtml .= <<<EOD
            <select type="date" name="{$input['name']}" class="form-control w-auto" id="{$input['id']}" data-colum="{$input['filter_colum']}">
               {$options}
            </select>
           EOD;
        }
    }


    return $generateHtml;
}


function currentPlan($user)
{
    $plan = Payment::with('plan')->where('user_id', $user->id)->where('payment_status', 1)->latest()->first();

    return $plan ? $plan->plan->plan_name : 'N/A';
}

function numberToWord($num = '')
{
    $num    = ( string ) ( ( int ) $num );
    
    if( ( int ) ( $num ) && ctype_digit( $num ) )
    {
        $words  = array( );
         
        $num    = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );
         
        $list1  = array('','one','two','three','four','five','six','seven',
            'eight','nine','ten','eleven','twelve','thirteen','fourteen',
            'fifteen','sixteen','seventeen','eighteen','nineteen');
         
        $list2  = array('','ten','twenty','thirty','forty','fifty','sixty',
            'seventy','eighty','ninety','hundred');
         
        $list3  = array('','thousand','million','billion','trillion',
            'quadrillion','quintillion','sextillion','septillion',
            'octillion','nonillion','decillion','undecillion',
            'duodecillion','tredecillion','quattuordecillion',
            'quindecillion','sexdecillion','septendecillion',
            'octodecillion','novemdecillion','vigintillion');
         
        $num_length = strlen( $num );
        $levels = ( int ) ( ( $num_length + 2 ) / 3 );
        $max_length = $levels * 3;
        $num    = substr( '00'.$num , -$max_length );
        $num_levels = str_split( $num , 3 );
         
        foreach( $num_levels as $num_part )
        {
            $levels--;
            $hundreds   = ( int ) ( $num_part / 100 );
            $hundreds   = ( $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '' );
            $tens       = ( int ) ( $num_part % 100 );
            $singles    = '';
             
            if( $tens < 20 ) { $tens = ( $tens ? ' ' . $list1[$tens] . ' ' : '' ); } else { $tens = ( int ) ( $tens / 10 ); $tens = ' ' . $list2[$tens] . ' '; $singles = ( int ) ( $num_part % 10 ); $singles = ' ' . $list1[$singles] . ' '; } $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' ); } $commas = count( $words ); if( $commas > 1 )
        {
            $commas = $commas - 1;
        }
         
        $words  = implode( ', ' , $words );
         
        $words  = trim( str_replace( ' ,' , ',' , ucwords( $words ) )  , ', ' );
        if( $commas )
        {
            $words  = str_replace( ',' , ' and' , $words );
        }
         
        return $words;
    }
    else if( ! ( ( int ) $num ) )
    {
        return 'Zero';
    }
    return '';
}


function activeMenu($route)
{
    if(is_array($route)){
        if(in_array(url()->current(),$route)){
            return 'active';
        }
    }
    if($route == url()->current()){
        return 'active';
    }
}