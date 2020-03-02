<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\EpolkaSettingsManager;
use App\Service\Security\SignChecker;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SettingsController extends AbstractController
{
    public function getAction(
        Request $request,
        LoggerInterface $requestLogger,
        EpolkaSettingsManager $settingsManager,
        SignChecker $signChecker
    ): Response {
        if (!$signChecker->checkSign()) {
            throw new BadRequestHttpException();
        }

        $requestLogger->info($request->getQueryString());

        return $this->json($settingsManager->getSettings());
    }
}
