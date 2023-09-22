<?php

namespace App\Service;

use ICal\ICal;
use Symfony\Component\HttpFoundation\File\File;

class ICSCalendarService
{
    public function parseCalendarFile(File $file): ICal
    {
        return new ICal($file);
    }
}
