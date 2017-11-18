<?php
namespace  App\Http\Controllers;

use App\Course;
use App\Teacher;
use Illuminate\Http\Request;

class TeacherCourseController extends Controller{

	private $rules = [
		'title' => 'required',
		'description' => 'required',
		'value' => 'required|numeric'
	];

	public function index($teacher_id){

		$teacher = Teacher::find($teacher_id);
		if($teacher){

			$courses = $teacher->courses;
			return $this->createSuccessResponse($courses, 200);
		}

		return $this->createErrorResponse("The teacher with id {$teacher_id} has not been found.", 404);
	}

	public function store(Request $request, $teacher_id){

		$teacher = Teacher::find($teacher_id);
		if($teacher){

			$this->validateRequest($request);

			// If we pass validation...
			$course = Course::create(
				[
					'title' => $request->get('title'),
					'description' => $request->get('description'),
					'value' => $request->get('value'),
					'teacher_id' => $teacher->id
				]
			);

			return $this->createSuccessResponse("The course with id {$course->id} has been successfully 
			created and associated with teacher with id {$teacher->id}", 201);
		}

		return $this->createErrorResponse("The teacher with id {$teacher_id} has not been found.", 404);
	}

	public function update(){

		return __METHOD__;
	}

	public function destroy(){

		return __METHOD__;
	}

	private function validateRequest($request){

		$this->validate($request, $this->rules);
	}
}