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

    #[Route('/calendar', name: 'app_calendar')]
    public function calendar(): Response
    {
        return $this->nantesUniversityRepositoryHttp->getCalendarFileFromDepartmentAndGroup('', 0);
    }

}
