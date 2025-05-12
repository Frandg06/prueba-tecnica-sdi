<?php

declare(strict_types=1);

namespace App\Http\Controllers;

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
}
