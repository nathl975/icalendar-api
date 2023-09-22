<?php

namespace App\Repository\Http;

use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NantesUniversityRepositoryHttp
{
    private HttpClientInterface $nantesUniversityIcsFileClient;
    private LoggerInterface $logger;
    private Filesystem $filesystem;
    private string $icsDirectory;

    public function __construct(
        HttpClientInterface $nantesUniversityIcsFileClient,
        LoggerInterface $logger,
        Filesystem $filesystem,
        string $icsDirectory
    ) {
        $this->nantesUniversityIcsFileClient = $nantesUniversityIcsFileClient;
        $this->logger = $logger;
        $this->filesystem = $filesystem;
        $this->icsDirectory = $icsDirectory;
    }

    public function getCalendarFileFromDepartmentAndGroup(string $department, int $group): File
    {
        $filename = '';
        try {
            $request = $this->nantesUniversityIcsFileClient->request('GET', '/calendar/ics', [
                'query' => [
                    'timetables[0]' => $group,
                ],
            ]);

            $response = $request->getContent();

            $filename = $this->icsDirectory.'/'.$department.'/'.$group.'.ics';
            $this->filesystem->dumpFile($filename, $response);

        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            $this->logger->error(__METHOD__.'_unable_to_find_calendar', [
                'exception' => $e,
            ]);
        }

        return new File($filename);
    }
}
