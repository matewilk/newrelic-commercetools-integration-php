<?php

namespace App\Client;

use Commercetools\Api\Client\ApiRequestBuilder;
use Commercetools\Api\Client\ClientCredentialsConfig;
use Commercetools\Api\Client\Config;
use Commercetools\Client\ClientCredentials;
use Commercetools\Client\ClientFactory;
use GuzzleHttp\ClientInterface;

class RequestBuilder
{
    private string $projectKey;
    private ClientInterface $client;
    private string $region;

    public function __construct()
    {
        $clientId = $_ENV['APP_CTP_CLIENT_ID'];
        $clientSecret = $_ENV['APP_CTP_CLIENT_SECRET'];
        $this->projectKey = $_ENV['APP_CTP_PROJECT_KEY'];
        $this->region = $_ENV['APP_CTP_REGION'];

        $authConfig = new ClientCredentialsConfig(
            new ClientCredentials($clientId, $clientSecret),
            [],
            'https://auth.' . $this->region . '.commercetools.com/oauth/token'
        );

        $this->client = ClientFactory::of()->createGuzzleClient(
            new Config([], 'https://api.' . $this->region . '.commercetools.com'),
            $authConfig
        );
    }

    public function getApiRequestBuilder()
    {
        $builder = new ApiRequestBuilder($this->client);
        return $builder->withProjectKey($this->projectKey);
    }
}
