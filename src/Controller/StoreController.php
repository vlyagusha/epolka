<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\EpolkaDataManager;
use App\Service\EpolkaSettingsManager;
use App\Service\Security\SignChecker;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class StoreController extends AbstractController
{
    public function postAction(
        Request $request,
        LoggerInterface $requestLogger,
        EpolkaDataManager $dataManager,
        EpolkaSettingsManager $settingsManager,
        SignChecker $signChecker
    ): Response {
        if (!$signChecker->checkSign()) {
            throw new BadRequestHttpException();
        }

        $requestLogger->info($request->getQueryString());

        $epolkaData = $dataManager->handleRequest($request);
        $dataManager->storeEpolkaData($epolkaData);

        return $this->json($settingsManager->getSettings());
    }
}
