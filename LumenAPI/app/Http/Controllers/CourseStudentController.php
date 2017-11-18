<?php

namespace  App\Http\Controllers;

use App\Course;
use App\Student;

class CourseStudentController extends Controller{

	public function __construct(){

		$this->middleware('oauth', ['except' => ['index']]);
	}

	public function index($course_id){

		$course = Course::find($course_id);
		if($course){

			$students = $course->students;

			return $this->createSuccessResponse($students, 200);
		}

		return $this->createErrorResponse("The course with id {$course_id} has not been found.", 404);
	}

	public function store($course_id, $student_id){

		$course = Course::find($course_id);
		if($course){

			$student = Student::find($student_id);
			if($student){

				if($course->students()->find($student->id)){

					return $this->createErrorResponse("The student with id {$student_id} 
					is already in the list of students for the course with id {$course_id}", 409);
				}

				$course->students()->attach($student->id);
				return $this->createSuccessResponse("The students with id {$student_id} has been 
				successfully added to the list of students for the course with id {$course_id}", 201);
			}

			return $this->createErrorResponse("The student with id {$student_id} has not been found.", 404);
		}

		return $this->createErrorResponse("The course with id {$course_id} has not been found.", 404);
	}

	public function destroy($course_id, $student_id){

		$course = Course::find($course_id);
		if($course){

			$student = Student::find($student_id);
			if($student){

				if(!$course->students()->find($student->id)){

					return $this->createErrorResponse("The student with id {$student_id} 
					does not exist in the list of students for the course with id {$course_id}", 404);
				}

				$course->students()->detach($student->id);
				return $this->createSuccessResponse("The students with id {$student_id} has been 
				successfully detached from the list of students for the course with id {$course_id}", 204);
			}

			return $this->createErrorResponse("The student with id {$student_id} has not been found.", 404);
		}

		return $this->createErrorResponse("The course with id {$course_id} has not been found.", 404);
	}
}