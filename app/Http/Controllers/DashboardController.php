<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonImmutable;
use App\Course;

class DashboardController extends Controller
{
    public function index()
    {

        $course_data = $this->getCourseTotals();

        return response()->json([
            'total_courses' => $course_data
        ], 200);
    }

    private function getCourseTotals()
    {

        $total_courses = Course::all()->count();

        return $total_courses;
    }

}
