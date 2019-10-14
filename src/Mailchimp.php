<?php

namespace Bounoable\Mailchimp;

use GuzzleHttp\Client;
use InvalidArgumentException;
use GuzzleHttp\RequestOptions;

class Mailchimp
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(string $apiKey)
    {
        $this->setApiKey($apiKey);
    }

    public function setApiKey(string $apiKey): void
    {
        $apiKeyParts = explode('-', $apiKey);

        if (count($apiKeyParts) !== 2) {
            throw new InvalidArgumentException('API key has an incorrect format.');
        }

        $this->client = new Client([
            'base_uri' => 'https://' . $apiKeyParts[1] . '.api.mailchimp.com/3.0/',
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode('anystring:' . $apiKey),
            ],
        ]);
    }

    public function sendRequest(string $method, string $endpoint, array $body = [], array $query = []): array
    {
        $options = [
            RequestOptions::QUERY => $query,
        ];

        if (count($body)) {
            $options[RequestOptions::JSON] = $body;
        }

        return json_decode(
            $this->client->request($method, trim($endpoint, '/'), $options)->getBody()->getContents()
        );
    }

    public function list(string $id): AudienceList
    {
        return new AudienceList($this, $id);
    }
}
