<?php

namespace App\Controller;

use App\Repository\Http\NantesUniversityRepositoryHttp;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    private NantesUniversityRepositoryHttp $nantesUniversityRepositoryHttp;
    public function __construct(NantesUniversityRepositoryHttp $nantesUniversityRepositoryHttp) {
        $this->nantesUniversityRepositoryHttp = $nantesUniversityRepositoryHttp;
    }

    #[Route('/calendar/{department}/{group}', name: 'app_calendar')]
    public function calendar(string $department, int $group): Response
    {
        return $this->nantesUniversityRepositoryHttp->getCalendarFileFromDepartmentAndGroup($department, $group);
    }

}
