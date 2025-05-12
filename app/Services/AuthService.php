<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
      Log::error($e->getMessage());
      throw new \Exception('Se ha producido un error al registrar el usuario', 422);
    }
  }

  /**
   * @param array $data
   * @return array
   * @throws ApiException
   */
  public function login(array $data): array
  {
    DB::beginTransaction();
    try {

      $user = User::where('email', $data['email'])->first();

      if (!Hash::check($data['password'], $user->password)) {
        throw new \Exception('La credenciales proporcionadas no son correctas', 422);
      }

      $user->tokens()->delete();

      DB::commit();
      return [
        'token' => $user->createToken('Spotify')->plainTextToken,
        'user' => $user->toResource(),
      ];
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      throw new \Exception('Se ha producido un error al iniciar sesión', 422);
    }
  }
}
