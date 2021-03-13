<?php

namespace App\Utility\sms;

use GuzzleHttp\Client;

class EskizSmsClient
{
    public $baseUrl;
    private $token;
    private $tokenLifetime;
    private $client;
    private $email;
    private $password;
    private $sender;

    public function __construct()
    {
        $this->loadConfig();
        $this->client = new Client([
            'base_uri' => $this->baseUrl
        ]);
        $this->login();
    }

    private function loadConfig()
    {
        $this->baseUrl =env('ESKIZ_SMS_URL', 'http://notify.eskiz.uz/api/');
        $this->tokenLifetime = env('ESKIZ_SMS_TOKEN_DURATION', 24 * 3600 * 30);
        $this->email =env('ESKIZ_SMS_EMAIL', 'test@eskiz.uz');
        $this->password = env('ESKIZ_SMS_PASSWORD', 'j6DWtQjjpLDNjWEk74Sx');
    }
    // [
    //     'token_lifetime' => env('ESKIZ_SMS_TOKEN_DURATION', 24 * 3600 * 30),
    //     'api_url' => env('ESKIZ_SMS_URL', 'http://notify.eskiz.uz/api/'),
    //     'email' => env('ESKIZ_SMS_EMAIL', 'test@eskiz.uz'),
    //     'password' => env('ESKIZ_SMS_PASSWORD', 'j6DWtQjjpLDNjWEk74Sx'),
    // ];
    private function login()
    {
        $this->token = cache()->remember('sms_auth_token', $this->tokenLifetime, function () {
            $res = $this->sendRequest('POST', 'auth/login', [
                'form_params' => [
                    'email' => $this->email,
                    'password' => $this->password
                ]
            ]);
            return $res['data']['token'];
        });

    }

    private function sendRequest($method, $uri, $options = [])
    {
        if ($this->token) {
            $options['headers']['Authorization'] = "Bearer {$this->token}";
        }
        if (in_array($method, ['GET', 'POST', 'PATCH', 'DELETE', 'PUT'])) {
            $res = $this->client->request($method, $uri, $options);
            if ($res->getStatusCode() === 200) {
                return json_decode($res->getBody()->getContents(), true);
            }
            throw new \Exception('Bad status code on response');
        } else {
            throw new \Exception('Method not found');
        }
    }

    public function send(string $number, string $text)
    {
        $res = $this->sendRequest('POST', 'message/sms/send', [
            'form_params' => [
                'mobile_phone' => $number,
                'message' => $text,
                'from' => $this->sender
            ],
        ]);

        return $res;
    }

    public function about()
    {
        return $this->sendRequest('GET', 'auth/user');
    }

    public function limits()
    {
        return $this->sendRequest('GET', 'user/get-limit');
    }
}
