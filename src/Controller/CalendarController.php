<?php

namespace App\Controller;

use App\Repository\Http\NantesUniversityRepositoryHttp;
use App\Service\ICSCalendarService;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    private NantesUniversityRepositoryHttp $nantesUniversityRepositoryHttp;
    private ICSCalendarService $ICSCalendarService;
    public function __construct(
        NantesUniversityRepositoryHttp $nantesUniversityRepositoryHttp,
        ICSCalendarService $ICSCalendarService
    ) {
        $this->nantesUniversityRepositoryHttp = $nantesUniversityRepositoryHttp;
        $this->ICSCalendarService = $ICSCalendarService;
    }

    #[Route('/calendar/{department}/{group}', name: 'app_calendar')]
    public function calendar(string $department, int $group): JsonResponse
    {
        $file = $this->nantesUniversityRepositoryHttp->getCalendarFileFromDepartmentAndGroup($department, $group);
        return new JsonResponse($this->ICSCalendarService->parseCalendarFile($file));
    }
}
