<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\View\View;

class EditCourseController extends Controller
{
    public function __invoke(Course $course): View
    {
        return view('admin.course.edit', [
            'course' => $course,
        ]);
    }
}
