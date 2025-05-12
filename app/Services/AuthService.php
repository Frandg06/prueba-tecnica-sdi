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
   * @throws Exception
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
      throw new \Exception(__('i18n.register_user_ko'), 422);
    }
  }

  /**
   * @param array $data
   * @return array
   * @throws Exception
   */
  public function login(array $data): array
  {
    DB::beginTransaction();
    try {

      $user = User::where('email', $data['email'])->first();

      if (!Hash::check($data['password'], $user->password)) {
        throw new \Exception(__('i18n.credentials_invalid'), 422);
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
      throw new \Exception(__('i18n.login_user_ko'), 422);
    }
  }


  /**
   * @param User $user
   * @throws Exception
   * @return void
   */
  public function logout(User $user): void
  {
    DB::beginTransaction();
    try {
      $user->tokens()->delete();
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      throw new \Exception(__('i18n.logout_ko'), 422);
    }
  }
}
