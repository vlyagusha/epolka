<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\EpolkaDataManager;
use App\Service\EpolkaSettingsManager;
use App\Service\Security\SignChecker;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class StoreController extends AbstractController
{
    public function postAction(
        Request $request,
        LoggerInterface $requestLogger,
        EntityManagerInterface $entityManager,
        EpolkaDataManager $dataManager,
        EpolkaSettingsManager $settingsManager,
        SignChecker $signChecker
    ): Response {
        if (!$signChecker->checkSign($request)) {
            throw new UnauthorizedHttpException($request->getQueryString());
        }

        $requestLogger->info($request->getQueryString());

        $epolkaData = $dataManager->handleRequest($request);
        $entityManager->persist($epolkaData);
        $entityManager->flush();

        return $this->json($settingsManager->getSettings());
    }
}
