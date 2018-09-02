<?php

namespace App\Helpers;

use App\models\Bank;
use App\models\Course;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;


class DbHelper
{
    public function __construct()
    {
        $this->bank = new Bank;
        $this->course = new Course;
    }

    public function existingDates()
    {
        return $this->course->existingDates();
    }

    public function seveFromHrmlArr($htmlArr)
    {
        $dataForSave = [];
        try{
            foreach ($htmlArr as $page){
                $dataForSave[] = $this->prepareData($page);
            }
            foreach ($dataForSave as $data){
                $this->saveCourse($data);
            }
        }
        catch (\Exception $e){
            return dump("Exeption in save from html arr method: , $e");
        }
        return true;
    }

    public function getAllCourses($params = null)
    {
        if($params){
            $params = ['date-get' => preg_split('[ ]', $params['date-get'])[0]];
        }
        return $this->course->getAllCourses($params);
    }

    public function saveCourse(Array $data)
    {
        return $this->course::insert($data);
    }

    public function prepareData($html)
    {
        $domCrawler = new DomCrawler($html);
        $bank = $this->bank;
        $data = [];
        $ru_date = trim($domCrawler->filter('.index-big-title .index-date')->text());
        $currency = trim($domCrawler->filter('a.listbox__link')->text());
        $table_rows = $domCrawler->filter('table.indextable tr');

        $table_rows->each(function (DomCrawler $node, $index) use ($bank, $ru_date, $currency, &$data, $table_rows){
            $arr = ['currency' => $currency, 'ru_date' => $ru_date];
            $cells = $node->filter('td');

            foreach ( $cells as $i => $n){
                if ($i == 0) { $arr['bank_id'] = $bank->bankId($n->textContent); }
                if ($i == 1) { $arr['purchase_price'] = trim($n->textContent); }
                if ($i == 3) { $arr[ 'sale_price'] =  trim($n->textContent); };
            };
            if(sizeof($arr) > 2){ $data[$index] = $arr; }
        });

        return $data;
    }
}
