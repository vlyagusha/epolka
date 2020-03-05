<?php declare(strict_types=1);

namespace App\Service\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SignChecker
{
    private string $requestSecret;

    public function __construct(string $requestSecret)
    {
        $this->requestSecret = $requestSecret;
    }

    public function checkSign(Request $request): void
    {
        if (!$request->query->has('sign')) {
            throw new BadRequestHttpException();
        } elseif (!$request->query->has('epolka_id')) {
            throw new BadRequestHttpException();
        } elseif (!$request->query->has('expires')) {
            throw new BadRequestHttpException();
        }

        $sign = $request->query->get('sign');
        $epolkaId = $request->query->get('epolka_id');
        $expires = $request->query->get('expires');
        $hash = hash_hmac('sha256', sprintf('%s&%s', $epolkaId, $expires), $this->requestSecret);

        if (!hash_equals($sign, $hash)) {
            throw new BadRequestHttpException();
        }
    }
}
