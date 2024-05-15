<?php

namespace Floodx92\KhGateway\Util;

use Floodx92\KhGateway\Contract\HttpClientInterface;
use Floodx92\KhGateway\Exception\HttpException;

class CurlHttpClient implements HttpClientInterface
{
    public const SANDBOX_URL = 'https://api.sandbox.khpos.hu/api/v1.0';
    public const PRODUCTION_URL = 'https://api.khpos.hu/api/v1.0';

    private const DEFAULT_OPTIONS = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: Floodx92-KhGateway/1.0',
            'Connection: close',
        ],
        CURLOPT_CUSTOMREQUEST => 'GET',
    ];

    public function __construct(
        private readonly string $baseUrl,
    ) {
    }

    public static function make(string $baseUrl): self
    {
        return new self($baseUrl);
    }

    /**
     * @throws HttpException
     */
    public function get(string $url, ?string $returnHeader = null): \stdClass|string
    {
        // if $returnHeader return the response header value
        if (null === $returnHeader) {
            return $this->sendRequest($url);
        }

        return $this->sendRequest($url, [
            CURLOPT_HEADER => true,
            CURLOPT_MAXREDIRS => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_NOBODY => true,
        ], $returnHeader);
    }

    /**
     * @throws HttpException
     */
    public function post(string $url, array $data): ?\stdClass
    {
        return $this->sendRequest($url, [
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
        ]);
    }

    /**
     * @throws HttpException
     */
    public function put(string $url, array $data): ?\stdClass
    {
        return $this->sendRequest($url, [
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => json_encode($data),
        ]);
    }

    /**
     * @throws HttpException
     */
    public function delete(string $url): ?\stdClass
    {
        return $this->sendRequest($url, [
            CURLOPT_CUSTOMREQUEST => 'DELETE',
        ]);
    }

    /**
     * Send an HTTP request using cURL.
     *
     * @param string $url     the URL to send the request to
     * @param array  $options additional cURL options
     *
     * @return \stdClass|null the response from the server
     *
     * @throws HttpException on cURL errors or when an HTTP error status code is received
     */
    private function sendRequest(string $url, array $options = [], ?string $returnHeader = null): \stdClass|string|null
    {
        if (!str_starts_with($url, '/')) {
            $url = '/'.$url;
        }

        $ch = curl_init($this->baseUrl.$url);

        curl_setopt_array($ch, self::DEFAULT_OPTIONS + $options);

        $response = curl_exec($ch);

        if (false === $response) {
            throw new HttpException(curl_error($ch), curl_errno($ch));
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // if $returnHeader is given and exists in the response, return its value
        if (null !== $returnHeader) {
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($response, 0, $headerSize);
            $header = explode("\r\n", $header);

            foreach ($header as $line) {
                if (str_starts_with($line, $returnHeader)) {
                    return trim(substr($line, strlen($returnHeader) + 2));
                }
            }
        }

        curl_close($ch);

        try {
            $response = json_decode($response, false, flags: JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new HttpException('Invalid JSON response', 0, $e);
        }

        if (empty($response)) {
            return null;
        }

        if ($statusCode > 499) {
            throw new HttpException('Server error.', $statusCode, resultMessage: $response->resultMessage ?? '', resultCode: $response->resultCode ?? 999);
        } elseif ($statusCode > 399) {
            throw new HttpException('Client error.', $statusCode, resultMessage: $response->resultMessage ?? '', resultCode: $response->resultCode ?? 999);
        }

        return $response;
    }
}
