# Send Sms use Infobip in Laravel
[![StyleCI](https://github.styleci.io/repos/155829796/shield?branch=master)](https://github.styleci.io/repos/155829796)

## Requirements

- PHP >= 7.1
- Laravel >= 5.5.*

## Installation

Require this package with composer.

```bash
composer require pnlinh/laravel-infobip-sms
```

To publishes config `config/infobip-sms.php`, use command:

```bash
php artisan vendor:publish --tag="infobip-sms"
```

You set config in `.env` or `config/infobip-sms.php`

```php
return [
    'from' => env('INFOBIP_FROM', 'Laravel'),
    'username' => env('INFOBIP_USERNAME', 'user'),
    'password' => env('INFOBIP_PASSWORD', '123456'),
];
```

## Usage

```php
// Send to one number
use Pnlinh\InfobipSms\Facades\InfobipSms;

$response = InfobipSms::send('84123456789', 'Hello Infobip');

// Send to multiple number
$response = InfobipSms::send(['84123456789', '84987654321'], 'Hello Infobip');

// Use Helper Function
$response = infobip_sms_send('84123456789', 'Hello Infobip');

// Get response
array:2 [
0 => 200
1 => {#362
 +"messages": array:1 [
   0 => {#355
     +"to": "84123456789"
     +"status": {#356
       +"groupId": 1
       +"groupName": "PENDING"
       +"id": 8
       +"name": "PENDING_ENROUTE"
       +"description": "Message sent to next instance"
     }
     +"smsCount": 1
     +"messageId": "2411455387981631234"
   }
 ]
}
]

$responseCode = $response[0];
$responseBody = $response[1];
```

## Credits

- [Pham Ngoc Linh](https://github.com/pnlinh)

For more info, please visit https://dev.infobip.com/send-sms/single-sms-message
