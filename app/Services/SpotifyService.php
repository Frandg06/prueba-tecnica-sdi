<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ApiException;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SpotifyService
{

  private const TOKEN_KEY = "spotify-token";

  /**
   * @return string
   * @throws ApiException
   */
  private function getToken(): string
  {
    try {
      return Cache::remember(self::TOKEN_KEY, 3500, function () {
        $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
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
