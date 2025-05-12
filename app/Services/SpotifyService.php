<?php

declare(strict_types=1);

namespace App\Services;

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

    public function album(string $id, string $market = ''): array
    {
        $response = $this->client->get('albums/'.$id, ['market' => $market]);

        return $response;
    }

    public function track(string $id, string $market = ''): array
    {
        $response = $this->client->get('tracks/'.$id, ['market' => $market]);

        return $response;
    }

    public function artist(string $id): array
    {
        $response = $this->client->get('artists/'.$id);

        return $response;
    }

    public function topTracks(string $id, string $market = ''): array
    {
        $response = $this->client->get('artists/'.$id.'/top-tracks', ['market' => $market]);

        return $response;
    }
}
