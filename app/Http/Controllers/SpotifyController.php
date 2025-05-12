<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GetAlbumRequest;
use App\Http\Requests\GetArtistTopTracksRequest;
use App\Http\Requests\GetTrackRequest;
use App\Models\Dtos\SearchDto;
use App\Services\SpotifyService;
use Illuminate\Http\JsonResponse;

class SpotifyController extends Controller
{
    public function __construct(private readonly SpotifyService $spotifyService) {}

    public function search(SearchDto $data): JsonResponse
    {
        $response = $this->spotifyService->search($data);

        return response()->json($response);
    }

    public function album(GetAlbumRequest $request, string $id): JsonResponse
    {
        $market = $request->safe()->market ?? '';
        $response = $this->spotifyService->album($id, $market);

        return response()->json($response);
    }

    public function track(GetTrackRequest $request, string $id): JsonResponse
    {
        $market = $request->safe()->market ?? '';
        $response = $this->spotifyService->track($id, $market);

        return response()->json($response);
    }

    public function artist(string $id): JsonResponse
    {
        $response = $this->spotifyService->artist($id);

        return response()->json($response);
    }

    public function topTracks(GetArtistTopTracksRequest $request, string $id): JsonResponse
    {
        $market = $request->safe()->market ?? '';
        $response = $this->spotifyService->topTracks($id, $market);

        return response()->json($response);
    }
}
