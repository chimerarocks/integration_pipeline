<?php
namespace Test\Stubs\Drivers;

use GuzzleHttp\Psr7\Response;
use Winker\Integration\Util\Http\Client;
use Winker\Integration\Util\Http\Exception\RequestException;

class Driver extends \Winker\Integration\Util\Http\Client\Driver {

    private function superlogicaTokenData() {
        if (empty($_SERVER['HTTP_SL_TOKEN'])) {
            return null;
        }

        return json_decode($_SERVER['HTTP_SL_TOKEN'], true);
    }

    public function getBaseUri() {
        $data = $this->superlogicaTokenData();

        if (empty($data)) {
            throw new \Exception('Auth token not found.');
        }

        if (!empty($data['app_token'])) {
            return "https://api.superlogica.net/v2/condor";
        } else {
            return "https://{$data['license']}.superlogica.net/condor/atual";
        }
    }

    public function cookiesEnabled() {
        return true;
    }

    public function afterFormatResponse(&$json) {
        if (empty($json['status']) && !isset($json['data'])) {
            $newJson    = ['data' => $json];
            $json       = $newJson;
        }
    }

    public function afterRequest(Response $response, $json) {
        $statusCode = $response->getStatusCode();

        if (!empty($json['status'])) {
            $statusCode = $json['status'];
        }

        if ($statusCode >= 400) {
            if (!empty($json['msg'])) {
                throw new RequestException([$json['msg']]);
            } else {
                throw new RequestException([$json]);
            }
        }
    }

    public function beforeRequest(Client $client, $method, $uri, &$options) {
        $tokenData = $this->superlogicaTokenData();

        if (empty($tokenData)) {
            throw new \Exception('Auth token not found. ref: auth/post');
        }

        if (!empty($tokenData['username'])) {
            $this->authWithLogin($client, $method, $uri, $options, $tokenData);
        } else if ($tokenData['app_token']) {
            $this->authWithAppToken($client, $method, $uri, $options, $tokenData);
        }
    }

    private function authWithAppToken(Client $client, $method, $uri, &$options, $tokenData) {
        if (empty($options['headers'])) {
            $options['headers'] = [];
        }

        $options['headers']['app_token']    = $tokenData['app_token'];
        $options['headers']['access_token'] = $tokenData['access_token'];
    }

    private function authWithLogin(Client $client, $method, $uri, &$options, $tokenData) {
        if (empty($this->session) && $uri != 'auth/post') {
            $response = $client->post('auth/post', [
                    'username'  => $tokenData['username'],
                    'password'  => $tokenData['license_key'],
                    'license'   => $tokenData['license']
                ]
            );

            if (empty($response['session'])) {
                throw new RequestError(['Session not found. ref: auth/post']);
            }
        }
    }

    public function getPageParamName() {
        return 'pagina';
    }
}