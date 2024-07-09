<?php

namespace App\Http\Middleware;


use App\Models\GeneralSetting;
use Closure;
use Pnlinh\InfobipSms\Facades\InfobipSms;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class isEmailVerified
{

    public function handle($request, Closure $next)
    {

        $general = GeneralSetting::first();

        $user = auth()->user();


        if ($general->is_email_verification_on && !$user->ev) {



            $randomNumber = rand(0, 999999);

            $user->verification_code = $randomNumber;
            $user->save();

            $data = [
                'email' => $user->email,
                'subject' => 'Email Verification Code',
                'message' => 'Your Account Verification Code is : ' . $randomNumber
            ];

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
                    $mail->addAddress($data['email']);
                    $mail->addReplyTo($general->site_email, $general->sitename);
                    $mail->isHTML(true);
                    $mail->Subject = $data['subject'];
                    $mail->Body    = $data['message'];
                    $mail->send();
                } catch (Exception $e) {
                    
                    throw new Exception($e);
                }
            }
            return redirect()->route('user.authentication.verify');
        }elseif ($general->is_sms_verification_on && !$user->sv) {
            $calling_code = rtrim(file_get_contents('https://ipapi.co/103.100.232.0/country_calling_code/'), "0");

            $randomNumber = rand(0, 999999);


            $user->sms_verification_code = $randomNumber;
            $user->save();

            try {
                $basic  = new \Nexmo\Client\Credentials\Basic(env("NEXMO_KEY"), env("NEXMO_SECRET"));
                $client = new \Nexmo\Client($basic);
    
                $receiverNumber = $calling_code . $user->phone;
                $message = 'Your SMS Verification Code is :' . $randomNumber;
    
                $message = $client->message()->send([
                    'to' => $receiverNumber,
                    'from' => $general->sitename,
                    'text' => $message
                ]);
            } catch (\Throwable $th) {
                $notify[] = ['error','Sms Provider Credentials Not Found'];

                return redirect()->back()->withNotify($notify);
            }

           
  
            return redirect()->route('user.authentication.verify');
        }


        return $next($request);
    }
}
