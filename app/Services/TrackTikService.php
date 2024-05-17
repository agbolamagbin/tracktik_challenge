<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;

class TrackTikService
{
    protected $client;
    private $endpoint;

    public function __construct()
    {
		$this->endpoint = config('services.tracktik.baseurl');
        $this->client = new Client([
            'base_uri' => $this->endpoint,
            'timeout'  => 10.0,
        ]);
    }

    public function createEmployee(array $data): JsonResponse
    {
        try {
            $response = $this->client->post('/rest/v1/employees', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getAccessToken(),
                ],
                'json' => $data,
            ]);

            $responseData = json_decode((string) $response->getBody(), true);
            return response()->json($responseData, $response->getStatusCode());
        } catch (RequestException $e) {
            return $this->handleApiException($e);
        }
    }

    public function updateEmployee($id, array $data): JsonResponse
    {
        try {
            $response = $this->client->put("/rest/v1/employees/{$id}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getAccessToken(),
                ],
                'json' => $data,
            ]);

            $responseData = json_decode((string) $response->getBody(), true);
            return response()->json($responseData, $response->getStatusCode());
        } catch (RequestException $e) {
            return $this->handleApiException($e);
        }
    }

    public function editEmployee($id, array $data): JsonResponse
    {
        try {
            $response = $this->client->patch("/rest/v1/employees/{$id}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getAccessToken(),
                ],
                'json' => $data,
            ]);

            $responseData = json_decode((string) $response->getBody(), true);
            return response()->json($responseData, $response->getStatusCode());
        } catch (RequestException $e) {
            return $this->handleApiException($e);
        }
    }

    public function deleteEmployee($id): JsonResponse
    {
        try {
            $response = $this->client->delete("/rest/v1/employees/{$id}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getAccessToken(),
                ],
            ]);

            $responseData = json_decode((string) $response->getBody(), true);
            return response()->json($responseData, $response->getStatusCode());
        } catch (RequestException $e) {
            return $this->handleApiException($e);
        }
    }

    protected function getAccessToken(): string
    {
        return Cache::get('tracktik_access_token');
    }

    private function handleApiException(RequestException $e): JsonResponse
    {
        if ($e->hasResponse()) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
			$bodyString = (string) $response->getBody();
            $body = json_decode($bodyString, true);
			

            // Check if 'message' is not set or null
			$message = isset($body['message']) ? $body['message'] : ($body ? $bodyString : 'No message provided');

			return response()->json([
				'error' => $body['error'] ?? 'error',
				'message' => $message,
			], $statusCode);
        }

        return response()->json([
            'error' => 'Unknown',
            'message' => 'No response from the server',
        ], 500);
    }
}
