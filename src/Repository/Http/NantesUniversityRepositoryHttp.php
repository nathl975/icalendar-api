<?php

namespace App\Repository\Http;

use Psr\Log\LoggerInterface;
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

    public function __construct(
        HttpClientInterface $nantesUniversityIcsFileClient,
        LoggerInterface $logger
    ) {
        $this->nantesUniversityIcsFileClient = $nantesUniversityIcsFileClient;
        $this->logger = $logger;
    }

    public function getCalendarFileFromDepartmentAndGroup(string $department, int $group): File
    {
        try {
            $request = $this->nantesUniversityIcsFileClient->request('GET', '/calendar/ics', [
                'query' => [
                    'timetables[0]' => '81605',
                ],
            ]);

            $response = $request->getContent();
            dump($response);die;

        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            $this->logger->error(__METHOD__.'_unable_to_find-calendar', [
                'exception' => $e,
            ]);
        }
    }
}
