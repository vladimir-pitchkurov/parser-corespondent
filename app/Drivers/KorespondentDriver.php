<?php

namespace App\Drivers;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as GuzzleClient;

class KorespondentDriver
{

    public function getContent($link)
    {
        $guzzleClient = new GuzzleClient();

        $guzzleClient->request('GET', $link, ['headers', array(
            'Proxy-Connection' => 'keep-alive',
            'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36',
            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'pragma' => 'no-cache',
            'cache-control' => 'no-cache',
            'upgrade-insecure-requests' => '1',
            'accept-encoding' => 'gzip, deflate, br',
            'accept-language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
            'Referer' => $link,
        )]);

        $response = $guzzleClient->get($link);
        return $response->getBody()->getContents();
    }

    public function getLinks($html)
    {
        $crawler = new DomCrawler($html);
        $re = '/\/ajax[\D\d]+=true/m';
        $hrefs = [];
        $links = $crawler->filter('.partition-selector>.listbox>li>ul>li>a');

        $links->each(function (DomCrawler $item, $index) use (&$hrefs, $re) {
            preg_match($re, $item->attr('href'), $matches);
            $hrefs[$index] = $matches[0];
        });
        return $hrefs;
    }

    public function getBanksCoursesHtml()
    {
        $link = "https://korrespondent.net/business/indexes/course_valjut/bank";
        $domain = '//korrespondent.net';

        $htmlArray[] = $this->getContent($link);
        $hrefs = $this->getLinks($htmlArray);
        if (sizeof($hrefs) > 0) {
            for ($i = 0; $i < sizeof($hrefs); $i++) {
                $htmlArray[] = $this->getContent($domain . $hrefs[$i]);
            }
        }

        return $htmlArray;
    }

}
