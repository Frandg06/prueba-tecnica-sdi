<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\SpotifyMarket;
use App\Http\Requests\GetAlbumRequest;
use App\Models\Dtos\SearchDto;
use App\Services\SpotifyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

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
}
