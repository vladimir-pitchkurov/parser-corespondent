<?php

namespace App\Http\Controllers\controllers;

use App\Drivers\KorespondentDriver;
use App\Helpers\DbHelper;
use App\models\Bank;
use App\models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;


class ParserController extends Controller
{
    protected $driver;
    protected $helper;

    public function __construct(KorespondentDriver $driver, DbHelper $helper)
    {
        $this->driver = new KorespondentDriver();
        $this->helper = $helper;
    }

    public function test()
    {
        $dataForSave = [];
        $htmlArray = $this->driver->getBanksCoursesHtml();
        $result = $this->helper->seveFromHrmlArr($htmlArray);
        dd($result);


    }

    public function index()
    {
        //$link = "https://korrespondent.net/business/indexes/course_valjut/bank/";
        $link = "https://korrespondent.net/ajax/module.aspx?spm_id=553&fid=2&IsAjax=true";


        $html = $this->driver->getContent($link);

        $domCrawler = new DomCrawler($html);
        echo $domCrawler->html();
    }

    public function second()
    {
        $link = "https://korrespondent.net/business/indexes/course_valjut/bank/";
        //$link = "https://korrespondent.net/ajax/module.aspx?spm_id=553&fid=2&IsAjax=true";
        $html = $this->driver->getContent($link);
        $data = $this->helper->prepareData($html);

        $course = new Course();
        //$this->helper->saveCourse($data);
        $courses = $this->helper->getAllCourses();
       // dump($data);

        //dd($courses);
        return Datatables::of($courses)->make(true);
    }

}
