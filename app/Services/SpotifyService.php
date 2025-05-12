<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ApiException;
use App\Exceptions\SpotifyException;
use App\Models\Dtos\SearchDto;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * @var string TOKEN_KEY Clave usada para almacenar el token de Spotify
 * @property string $apiBaseUrl
 * @property string $authUrl
 */
class SpotifyService
{

  private const TOKEN_KEY = "spotify-token";

  private string $apiBaseUrl;
  private string $authUrl;

  public function __construct()
  {
    $this->apiBaseUrl = config('spotify.api_url');
    $this->authUrl = config('spotify.spotify_auth_url');
  }

  /**
   * @param SearchDto $data
   * @return array
   * @throws SpotifyException
   */
  public function search(SearchDto $data): array
  {
    $response = Http::withToken($this->getToken())->get(
      $this->apiBaseUrl . "/search",
      $data->toArray()
    )->json();

    if (isset($response['error'])) {
      throw new SpotifyException($response['error']['message'], $response['error']['status']);
    }

    return $response;
  }

  /**
   * @return string
   * @throws ApiException
   */
  private function getToken(): string
  {
    try {
      return Cache::remember(self::TOKEN_KEY, 3500, function () {
        $response = Http::asForm()->post($this->authUrl, [
          'grant_type'    => 'client_credentials',
          'client_id'     => config('spotify.client_id'),
          'client_secret' => config('spotify.client_secret'),
        ])->throw()->json();

        return $response['access_token'];
      });
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      throw new ApiException(__('i18n.spotify_token_ko'), 500);
    }
  }
}
