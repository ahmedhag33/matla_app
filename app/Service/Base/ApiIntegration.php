<?php

namespace App\Service\Base;

use App\Exceptions\ApiException;
use App\Service\Enum\ApiBody;
use App\Service\Enum\HttpStatusCode;
use App\Service\Enum\RequestMethod;

trait ApiIntegration
{
    use JsonAPIMessages;
    /**
     * Build and send an API request
     *
     * @param string $request_method
     * @param string $url
     * @param array $body
     * @return array
     * @throws ApiException
     */
    protected function bulidRequest($request_method, $url, $body = [], $header = [], $type = ApiBody::JSON->value)
    {
        // Check if the request method is valid
        if (!in_array($request_method, array_map(fn($status) => $status->value, RequestMethod::cases()))) {
            throw new ApiException('Invalid request method', HttpStatusCode::BAD_REQUEST->value);
        }
        // Check if the request body is valid
        if (empty($body)) {
            throw new ApiException('Invalid request body', HttpStatusCode::BAD_REQUEST->value);
        }
        if (empty($header)) {
            throw new ApiException('Invalid request header', HttpStatusCode::BAD_REQUEST->value);
        }
        // Build the request using the clientRequest function
        $request = clientRequest($request_method, $url, $header, json_encode($body));
        // Send the request using the client function and get the response
        $data = [$type => $body];
        // Send the request using the client function and get the response
        $response = client()->send($request, $data);
        // Decode the response body as JSON and return it as an array
        $response = json_decode($response->getBody(), true);
        // Return the response
        return $response;
    }
    /**
     * Send a GET request to the specified URL with optional query parameters
     *
     * @param string $url
     * @param array $body
     * @return array
     * @throws ApiException
     */
    protected function getRequest($url, $body = [])
    {
        $response = client()->get($url, ['query' => $body, 'timeout' => 300]);
        // Check if the response status code is not 200 or 201, throw an exception
        if ($response->getStatusCode() != HttpStatusCode::OK->value && $response->getStatusCode() != HttpStatusCode::CREATED->value) {
            throw new ApiException('No request found', $response->getStatusCode());
        }
        // Decode the response body as JSON and return it as an array
        $data = json_decode($response->getBody(), true);
        // Return the response
        return $data;
    }
    /**
     * Send a POST request to the specified URL with optional form parameters
     *
     * @param string $url
     * @param array $body
     * @return array
     * @throws ApiException
     */
    protected function postRequest($url, $body = [], $type = ApiBody::JSON->value)
    {
        $response = client()->post($url, [$type => $body, 'timeout' => 300]);
        // Check if the response status code is not 200 or 201, throw an exception
        if ($response->getStatusCode() != HttpStatusCode::OK->value && $response->getStatusCode() != HttpStatusCode::CREATED->value) {
            throw new ApiException('No request found', $response->getStatusCode());
        }
        // Decode the response body as JSON and return it as an array
        $data = json_decode($response->getBody(), true);
        // Return the response
        return $data;
    }
}
