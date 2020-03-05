<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\EpolkaFormatter;
use App\Service\EpolkaSettingsManager;
use App\Service\Security\SignChecker;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends AbstractController
{
    public function getAction(
        Request $request,
        LoggerInterface $requestLogger,
        EpolkaSettingsManager $settingsManager,
        EpolkaFormatter $formatter,
        SignChecker $signChecker
    ): Response {
        $signChecker->checkSign($request);

        $requestLogger->info($request->getQueryString());

        return new Response(implode(';', [
            Response::HTTP_OK,
            $formatter->formatString($settingsManager->getSettings())
        ]));
    }
}
