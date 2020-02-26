<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReceiveDataController
{
    public function indexAction(Request $request): Response
    {
        return new Response('OK');
    }
}
