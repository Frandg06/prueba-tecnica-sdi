<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\SpotifyException;
use App\Http\Client\SpotifyClient;
use App\Models\Dtos\SearchDto;

/**
 * @property SpotifyClient $client
 */
class SpotifyService
{

  public function __construct(private readonly SpotifyClient $client) {}

  public function search(SearchDto $data): array
  {
    $response = $this->client->get('search', $data->toArray());
    return $response;
  }
}
