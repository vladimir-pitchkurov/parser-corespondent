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
        $dates = false;
        $dates = $this->helper->existingDates();

        return view('table', ['uri' => '/all', 'dates' => $dates]);
    }

    public function second(Request $request)
    {
        $params = null;
        if($request->input('date-get')){
            $params = ['date-get' => $request->input('date-get')];
        }

        $link = "https://korrespondent.net/business/indexes/course_valjut/bank/";
        $html = $this->driver->getContent($link);
        $data = $this->helper->prepareData($html);

        $course = new Course();
        //$this->helper->saveCourse($data);
        $courses = $this->helper->getAllCourses($params);

        return Datatables::of($courses)->make(true);
    }

}
