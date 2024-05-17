<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;

class TrackTikAuth
{
    public function handle($request, Closure $next)
    {
        if (Cache::has('tracktik_access_token')) {
            $accessToken = Cache::get('tracktik_access_token');
        } else {
            $accessToken = $this->getAccessToken();
            if (!is_string($accessToken)) {
                // Return the error response if getAccessToken failed
                return $accessToken;
            }
        }
        $request->headers->set('Authorization', 'Bearer ' . $accessToken);

        return $next($request);
    }

    private function getAccessToken()
    {
        try {
            $response = Http::post(config('services.tracktik.baseurl').'/rest/oauth2/access_token', [
                'grant_type' => 'password',
                'client_id' => config('services.tracktik.client_id'),
                'client_secret' => config('services.tracktik.client_secret'),
                'username' => config('services.tracktik.username'),
                'password' => config('services.tracktik.password'),
            ]);

            if ($response->failed()) {
                return $this->createErrorResponse($response);
            }
			
			$accessToken = $response->json()['access_token'];
			// Store the token in cache for the token's lifetime
			Cache::put('tracktik_access_token', $accessToken, $response->json()['expires_in'] - 60); // Subtract a minute for buffer

            return $accessToken;
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Exception occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function createErrorResponse($response)
    {
        $statusCode = $response->getStatusCode();
        $body = json_decode((string) $response->getBody(), true);

        return response()->json([
            'error' => $body['error'] ?? 'Error',
            'message' => $body['message'] ?? 'Failed to authenticate with Tracktik API'
        ], $statusCode);
    }
}
