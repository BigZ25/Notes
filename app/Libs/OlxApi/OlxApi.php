<?php

namespace App\Libs\OlxApi;

use App\DB\Models\OlxCode;
use App\DB\Models\OlxToken;
use Exception;
use Illuminate\Support\Facades\Http;

const scope = 'read write v2';

class OlxApi
{
    public static function codeUrl()
    {
        return 'https://www.olx.pl/oauth/authorize/?client_id=' . env('OLX_API_CLIENT_ID') . '&response_type=code&scope=' . scope;
    }

    /**
     * @throws Exception
     */
    private static function accessToken()
    {
        $currentAccessToken = OlxToken::current();

        if ($currentAccessToken === null) {
            return self::getAccessToken();
        }

        if ($currentAccessToken->need_refresh === true) {
            if ($currentAccessToken->refresh_token_expired === false) {
                return self::refreshAccessToken($currentAccessToken);
            } else {
                return self::getAccessToken();
            }
        }

        return $currentAccessToken;
    }

    private static function getAccessToken()
    {
        if (OlxCode::all()->count() === 0) {
            throw new Exception("Brak kodu dostępu do OLX.");
        }

        $code = OlxCode::current();

        $data = [
            'grant_type' => 'authorization_code',
            'scope' => scope,
            'client_id' => env('OLX_API_CLIENT_ID'),
            'client_secret' => env('OLX_API_CLIENT_SECRET'),
            'code' => $code->code,
        ];

        $response = Http::post(env('OLX_BASE_URL') . 'api/open/oauth/token', $data);
        if ($response->failed()) {
            throw new Exception($response->json('error_human_title'));
        } else {
            $data = $response->json();

            OlxToken::query()->delete();

            $olxToken = OlxToken::create([
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
                'expires_in' => $data['expires_in'],
                'timestamp' => time(),
            ]);

            return $olxToken;
        }
    }

    private static function refreshAccessToken($olxToken)
    {
        if ($olxToken !== null) {
            $data = [
                'grant_type' => 'refresh_token',
                'client_id' => env('OLX_API_CLIENT_ID'),
                'client_secret' => env('OLX_API_CLIENT_SECRET'),
                'refresh_token' => $olxToken->refresh_token,
            ];

            $response = Http::withHeaders([

            ])->post(env('OLX_BASE_URL') . 'api/open/oauth/token', $data);

            if ($response->failed()) {
                return $response->throw();
            } else {
                $data = $response->json();

                $olxToken->update([
                    'access_token' => $data['access_token'],
                    'refresh_token' => $data['refresh_token'],
                    'expires_in' => $data['expires_in'],
                    'timestamp' => time(),
                ]);
            }

            return $olxToken;
        }

        return null;
    }

    public static function addAdvert($data)
    {
        try {
            $olxToken = self::accessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $olxToken->access_token,
                'Version' => '2.0',
                'Content-Type' => 'application/json',
            ])->post(env('OLX_BASE_URL') . 'api/partner/adverts', $data);

            if ($response->ok()) {
                return response()->json(['data' => $response->json('data')], 200);
            } else {
                if ($response->json() !== null) {
                    return response()->json($response->json('error_human_title') ?? $response->json('error')['validation'][0]['field'] . ": " . $response->json('error')['validation'][0]['title'],
                        $response->status());
                }

                return response()->json($response->reason(), $response->status());
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

//    public static function removeAdvert($advertOlxId)
//    {
//        $response = self::getAdvert($advertOlxId);
//
//        if ($response->isOk() === true) {
//            $data = $response->getOriginalContent()['data'];
//
//            $status = $data['status'];
//
//            if ($status === AdvertOlxStatusesEnum::ACTIVE) {
//                try {
//                    $olxToken = self::accessToken();
//
//                    $data = [
//                        "command" => "deactivate",
//                        "is_success" => false,
//                    ];
//
//                    $response = Http::withHeaders([
//                        'Authorization' => 'Bearer ' . $olxToken->access_token,
//                        'Version' => '2.0',
//                        'Content-Type' => 'application/json',
//                    ])->post(env('OLX_BASE_URL') . 'api/partner/adverts/' . $advertOlxId . '/commands', $data);
//
//                    if ($response->status() === 204) {
//                        return response()->json("OK", 200);
//                    } else {
//                        return response()->json($response->json('error_human_title'), $response->status());
//                    }
//                } catch (Exception $e) {
//                    return response()->json($e->getMessage(), 500);
//                }
//            } elseif ($status === AdvertOlxStatusesEnum::REMOVED_BY_USER) {
//                return response()->json("OK", 200);
//            } else {
//                return response()->json("Nie można usunąć ogłoszenia z OLX. Proszę spróbować później", 500);
//            }
//        } elseif ($response->getStatusCode() === 404) {
//            return response()->json("Not exists", 200);
//        } else {
//            return $response;
//        }
//    }

//    public static function getAdvert($advertOlxId)
//    {
//        try {
//            $olxToken = self::accessToken();
//
//            $response = Http::withHeaders([
//                'Authorization' => 'Bearer ' . $olxToken->access_token,
//                'Version' => '2.0',
//                'Content-Type' => 'application/json',
//            ])->get(env('OLX_BASE_URL') . 'api/partner/adverts/' . $advertOlxId);
//            if ($response->ok()) {
//                return response()->json(['data' => $response->json('data')], 200);
//            } else {
//                if ($response->json() !== null) {
//                    return response()->json($response->json('error_human_title'), $response->status());
//                }
//
//                return response()->json($response->reason(), $response->status());
//            }
//        } catch (Exception $e) {
//            return response()->json($e->getMessage(), 500);
//        }
//    }
}
