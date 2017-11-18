<?php

namespace  App\Http\Controllers;

use App\Course;

class CourseStudentController extends Controller{

	public function index($course_id){

		$course = Course::find($course_id);

		if($course){

			$students = $course->students;

			return $this->createSuccessResponse($students, 200);
		}

		return $this->createErrorResponse("The course with id {$course_id} has not been found.", 404);
	}

	public function store(){

		return __METHOD__;
	}

	public function destroy(){

		return __METHOD__;
	}
}