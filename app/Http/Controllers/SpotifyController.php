<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\SpotifyMarket;
use App\Models\Dtos\SearchDto;
use App\Services\SpotifyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class SpotifyController extends Controller
{

  public function __construct(private readonly SpotifyService $spotifyService) {}

  public function search(SearchDto $data): JsonResponse
  {
    $response = $this->spotifyService->search($data);

    return response()->json($response);
  }

  public function album(Request $request, string $id): JsonResponse
  {
    $validate = $request->validate([
      'market' => ['nullable', 'string', new Enum(SpotifyMarket::class)],
    ]);

    $market = $validate['market'] ?? '';

    $response = $this->spotifyService->album($id, $market);

    return response()->json($response);
  }
}
