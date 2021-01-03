<?php

namespace App\Http\Middleware\Api;

use App\Exceptions\Api\UnauthorizedException;
use App\Services\Api\UserService;
use Closure;
use Illuminate\Http\Request;

class EnsureUserId
{
  protected $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    if (!$request->hasHeader('X-User-Id')) {
      throw new UnauthorizedException();
    }

    $request->merge([
      'user_id' => (int) $request->header('X-User-Id')
    ]);

    return $next($request);
  }
}
