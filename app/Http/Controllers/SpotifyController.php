<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\SpotifyService;

class SpotifyController extends Controller
{

  public function __construct(private readonly SpotifyService $spotifyService) {}
}
