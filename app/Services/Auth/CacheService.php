<?php
namespace App\Services\Auth;

use Illuminate\Support\Facades\Cache;

class CacheService{

protected function key(String $email):String{
return 'PendingUser'. $email;
}

public function Store(String $email,array $data):void{
    Cache::put($this->Key($email), $data,  now()->addMinutes(10));
}

public function get(String $email): ?array{
return Cache::get($this->key($email));
}

public function forget(string $email): void{
    Cache::forget($this->key($email));
}

}