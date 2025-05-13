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

    /**
     * @param SearchDto $data
     * @return array
     */
    public function search(SearchDto $data): array
    {
        $response = $this->client->get('search', $data->toArray());

        return $response;
    }

    /**
     * @param string $id
     * @param string $market
     * @return array
     */
    public function album(string $id, string $market = ''): array
    {
        $response = $this->client->get('albums/' . $id, ['market' => $market]);

        return $response;
    }

    /**
     * @param string $id
     * @param string $market
     * @return array    
     */
    public function track(string $id, string $market = ''): array
    {
        $response = $this->client->get('tracks/' . $id, ['market' => $market]);

        return $response;
    }

    /**
     * @param string $id
     * @return array
     */
    public function artist(string $id): array
    {
        $response = $this->client->get('artists/' . $id);

        return $response;
    }

    /**
     * @param string $id
     * @param string $market
     * @return array
     */
    public function topTracks(string $id, string $market = ''): array
    {
        $response = $this->client->get('artists/' . $id . '/top-tracks', ['market' => $market]);

        return $response;
    }
}
