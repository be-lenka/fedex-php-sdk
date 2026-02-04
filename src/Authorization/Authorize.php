<?php

namespace belenka\fedex\Authorization;

use belenka\fedex\Exceptions\AuthorizationException;
use belenka\fedex\Traits\rawable;
use belenka\fedex\Traits\switchableEnv;
use GuzzleHttp\Client;

class Authorize
{

    use switchableEnv,
        rawable;

    private const HTTP_TIMEOUT_SECONDS = 10;

    private $client_id;

    private $client_secret;

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

    /**
     * @throws AuthorizationException
     */
    public function authorize()
    {
        if (!isset($this->client_id) || !isset($this->client_secret)) {
            throw new AuthorizationException('Please provide auth credentials');
        }

        try {
            $httpClient = new Client([
                'timeout'         => self::HTTP_TIMEOUT_SECONDS,
                'connect_timeout' => self::HTTP_TIMEOUT_SECONDS
            ]);

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

            if ($query->getStatusCode() !== 200) {
                throw new AuthorizationException('Response statusCode is not ok.');
            }

            if($this->raw) {
                return $query;
            }
            
            $body = json_decode($query->getBody()->getContents());

            $responseDto = (new AuthorizationResponseDto())
                ->setAccessToken($body->access_token)
                ->setTokenType($body->token_type)
                ->setExpiresIn($body->expires_in)
                ->setScope($body->scope);

            return $responseDto;
        } catch (\Exception $e) {
            throw new AuthorizationException('Authorization failed; ' . $e->getMessage());
        }
    }
}
