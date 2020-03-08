<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\EpolkaDataManager;
use App\Service\EpolkaSettingsFormatter;
use App\Service\EpolkaSettingsManager;
use App\Service\Security\SignChecker;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends AbstractController
{
    public function postAction(
        Request $request,
        LoggerInterface $requestLogger,
        EpolkaDataManager $dataManager,
        EpolkaSettingsManager $settingsManager,
        EpolkaSettingsFormatter $formatter,
        SignChecker $signChecker
    ): Response {
        $signChecker->checkSign($request);

        $requestLogger->info($request->getQueryString());

        $epolkaData = $dataManager->handleRequest($request);
        $dataManager->storeEpolkaData($epolkaData);

        return new Response(implode(';', [
            Response::HTTP_OK,
            $formatter->formatString($settingsManager->getSettings())
        ]));
    }
}
