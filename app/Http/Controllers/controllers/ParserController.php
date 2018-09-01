<?php

namespace App\Http\Controllers\controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as GuzzleClient;

class ParserController extends Controller
{
    public function index()
    {
        //$link = "https://korrespondent.net/business/indexes/course_valjut/bank/";
        $link = "https://korrespondent.net/ajax/module.aspx?spm_id=553&fid=2&IsAjax=true";

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

        //dd(database_path());
        $response = $guzzleClient->get($link);
        $html = $response->getBody()->getContents();
        //echo $html;
        $domCrawler = new DomCrawler($html);
        echo $domCrawler->html();
        /*$table = $domCrawler->filter('table.indextable')->each(function ($item, $index, $arr){
            echo '<p>'.$item->html().'</p>';
        });*/
        //echo $table->html();


    }

    public function second()
    {

        //$link = "https://korrespondent.net/business/indexes/course_valjut/bank/";
        $link = "https://korrespondent.net/ajax/module.aspx?spm_id=553&fid=2&IsAjax=true";

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
        $html = $response->getBody()->getContents();

        $domCrawler = new DomCrawler($html);

        $ru_date = $domCrawler->filter('.index-big-title .index-date');
        echo 'ru_date => '.$ru_date->text().'<br>';
         $currency = $domCrawler->filter('a.listbox__link');
        echo 'currency => '.$currency->text().'<br>';

        $table_rows = $domCrawler->filter('table.indextable>tbody>tr');

        $table_rows->each(function (DomCrawler $node, $index){
            echo 'Row number - '.$index.'<br>';
            $cells = $node->filter('td');
            $cells->each(function (DomCrawler $n, $i){
                echo $i.' => '.$n->text().'<br>';
            });
            echo '<br>';
        });

    }
}
