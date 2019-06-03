<?php 
namespace App\Services;

use YourApp\User;
use Tymon\JWTAuth\JWTAuth;
// use JWTAuth;
use Auth;
use Illuminate\Contracts\Cache\Repository;

class UserTempStorage
{

    const USER_CACHE_NAMESPACE = 'users:temp';

    /**
     * Cache Repository instance.
     * 
     * @var Repository
     */
    protected $cache;

    /**
     * User instance
     *
     * @var User
     */
    protected $user;

    public function __construct(Repository $cache, Auth $jwtAuth)
    {
        $this->cache = $cache;
        $this->user = Auth::user();
    }

    protected function cacheKey($key)
    {
        return implode(':', [self::USER_CACHE_NAMESPACE, $this->user->id, $key]);
    }

    public function get($key)
    {
        return $this->cache->get($this->cacheKey($this->encodeSession($key)));
    }

    // 1440 = 24 hours * 60 minutes --> cache TTLs for Laravel are in minutes.
    // when the TTL expires, the data won't be returned by the cache service anymore.
    // since it is "temp" data, this should be plenty of time for it to be cached.
    public function put($key, $value, $ttl = 14440)
    {
        $this->cache->put($this->cacheKey($this->encodeSession($key)),$value, $ttl);
    }

    public function encodeSession ($data) {
      return base64_encode( (string) $data);
    }

    public function decodeSession ($data) {
      return base64_decode($data);
    }

}