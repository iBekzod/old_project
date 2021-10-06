<?php

return [
    'token_lifetime' => env('ESKIZ_SMS_TOKEN_DURATION', 24 * 3600 * 30),
    'api_url' => env('ESKIZ_SMS_URL', 'http://notify.eskiz.uz/api/'),
    'email' => env('ESKIZ_SMS_EMAIL', 'zetsoft.info@gmail.com'),
    // 'email' => env('ESKIZ_SMS_EMAIL', 'test@eskiz.uz'),
    'password' => env('ESKIZ_SMS_PASSWORD', 'A79k56eZICw0YEBQU28vs9Ya8O8dEdLevT19OUrh'),
    // 'password' => env('ESKIZ_SMS_PASSWORD', 'j6DWtQjjpLDNjWEk74Sx'),
];
