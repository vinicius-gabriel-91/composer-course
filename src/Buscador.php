<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var Crawler
     */
    private $crawler;

    public function __construct(ClientInterface $client, Crawler $crawler)
    {
        $this->client = $client;
        $this->crawler = $crawler;
    }

    public function buscar($url): array
    {
        $request = $this->client->request('GET', $url);
        $html = $request->getBody();

        $this->crawler->addHtmlContent($html);

        $elementos = $this->crawler->filter('span.card-curso__nome');

        $cursos = [];

        foreach ($elementos as $elemento) {
            $cursos[] = $elemento->textContent;
        }

        return $cursos;
    }
}
