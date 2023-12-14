<?php

namespace modules\np\services;

use Craft;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Api
{
    public static function get($path, $options = [])
    {
        return self::api('GET', $path, null, $options);
    }

    public static function post($path, $data = [], $options = [])
    {
        return self::api('POST', $path, $data, $options);
    }
    
    private static function api($method, $path, $data = [], $options = [])
    {
        static $client = null;

        $defaultHeaders = [
            'X-Requested-With' => 'XMLHttpRequest',
            'Authorization' => 'Bearer ' . Craft::$app->session->get('token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        if ($client === null) {
            $client = new Client([
                'base_uri' => getenv('DEFAULT_SITE_URL'),
                'headers' => $defaultHeaders,
                'timeout'  => 25
            ]);
        }

        try {
            if ($data) {
                $options['json'] = $data;
            }
            $request = $client->request($method, $path, $options);
            Craft::$app->getResponse()->setStatusCode($request->getStatusCode());
            return json_decode($request->getBody());
        } catch (RequestException $e) {
            $response = $e->getResponse();
           
            if ($response) {
                $body = json_decode($response->getBody());
                if (is_object($body)) {
                    Craft::$app->getResponse()->setStatusCode($response->getStatusCode());
                    $body->status = $response->getStatusCode();
                }
            }
            $jsonBody = isset($body) ? (object) $body : false;
            return $jsonBody;
        }
    }
}
