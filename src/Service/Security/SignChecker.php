<?php declare(strict_types=1);

namespace App\Service\Security;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SignChecker
{
    private string $requestSecret;

    private RequestStack $requestStack;

    public function __construct(string $requestSecret, RequestStack $requestStack)
    {
        $this->requestSecret = $requestSecret;
        $this->requestStack = $requestStack;
    }

    public function checkSign(): bool
    {
        $request = $this->requestStack->getMasterRequest();

        if ($request === null) {
            throw new BadRequestHttpException();
        }

        if (!$request->query->has('sign')) {
            return false;
        } elseif (!$request->query->has('epolka_id')) {
            return false;
        } elseif (!$request->query->has('sensors')) {
            return false;
        }
        $sign = $request->query->get('sign');
        $epolkaId = $request->query->get('epolka_id');
        $sensors = $request->query->get('sensors');
        $hash = hash_hmac('sha256', sprintf('%s&%s', $epolkaId, $sensors), $this->requestSecret);

        return hash_equals($sign, $hash);
    }
}
