<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthService
{

  /**
   * @param array $data
   * @throws ApiException
   * @return array
   */
  public function register(array $data): array
  {
    DB::beginTransaction();
    try {

      $user = User::create($data);

      $user->createToken('Spotify')->plainTextToken;

      DB::commit();
      return [
        'token' => $user->createToken('Spotify')->plainTextToken,
        'user' => $user->toResource(),
      ];
    } catch (\Exception $e) {
      DB::rollBack();
      throw new \Exception('Se ha producido un error al registrar el usuario', 422);
    }
  }
}
