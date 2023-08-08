<?php

namespace belenka\fedex\Authorization;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use belenka\fedex\Exceptions\MissingAuthCredentialsException;
use belenka\fedex\Traits\rawable;
use belenka\fedex\Traits\switchableEnv;

class Authorize
{

    use switchableEnv,
        rawable;

    private $client_id;
    private $client_secret;
    private $access_token = false;

    /**
     * @param  string  $client_id
     * @return Authorize
     */
    public function setClientId(string $client_id): Authorize
    {
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * @param  string  $client_secret
     * @return Authorize
     */
    public function setClientSecret(string $client_secret): Authorize
    {
        $this->client_secret = $client_secret;
        return $this;
    }
    
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @return mixed|string
     * @throws MissingAuthCredentialsException
     * @throws GuzzleException
     */
    public function authorize()
    {
        $httpClient = new Client();
        if (isset($this->client_id) && isset($this->client_secret)) {
            try {
                $query = $httpClient->request('POST', $this->getApiUri('/oauth/token'), [
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                    'form_params' => [
                        'grant_type' => 'client_credentials',
                        'client_id' => $this->client_id,
                        'client_secret' => $this->client_secret,
                    ]
                ]);
                if ($query->getStatusCode() === 200) {
                    if($this->raw) {
                        return $query;
                    }
                    
                    $body = json_decode($query->getBody()->getContents());
                    $this->access_token = $body->access_token;
                    
                    return $body;
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new MissingAuthCredentialsException('Please provide auth credentials');
        }
    }
}
