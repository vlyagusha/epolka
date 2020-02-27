<?php declare(strict_types=1);

namespace App\Service\Security;

use Symfony\Component\HttpFoundation\Request;

class SignChecker
{
    public function checkSign(Request $request): bool
    {
        return $request->query->has('sign');
    }
}
