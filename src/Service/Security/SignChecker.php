<?php declare(strict_types=1);

namespace App\Service\Security;

use Symfony\Component\HttpFoundation\Request;

class SignChecker
{
    private string $requestSecret;

    public function __construct(string $requestSecret)
    {
        $this->requestSecret = $requestSecret;
    }

    public function checkSign(Request $request): bool
    {
        if (!$request->query->has('sign') || !$request->query->has('epolka_id')) {
            return false;
        }
        $sign = $request->query->get('sign');
        $epolkaId = $request->query->get('epolka_id');
        $hash = hash_hmac('sha256', $epolkaId, $this->requestSecret);

        return hash_equals($sign, $hash);
    }
}
