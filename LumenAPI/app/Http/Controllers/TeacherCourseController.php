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

	public function __construct(){

		$this->middleware('oauth', ['except' => ['index']]);
	}

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

	public function update(Request $request, $teacher_id, $course_id){

		$teacher = Teacher::find($teacher_id);
		if($teacher){

			$course = Course::find($course_id);
			if($course){

				$this->validateRequest($request);

				$course->title = $request->get('title');
				$course->description = $request->get('description');
				$course->value = $request->get('value');
				$course->teacher_id = $teacher_id;

				$course->save();
				return $this->createSuccessResponse("The course with id {$course->id} has been 
				successfully updated", 204);
			}

			return $this->createErrorResponse("The course with id {$course_id} has not been found.", 404);
		}

		return $this->createErrorResponse("The teacher with id {$teacher_id} has not been found.", 404);
	}

	public function destroy($teacher_id, $course_id){

		$teacher = Teacher::find($teacher_id);
		if($teacher){

			$course = Course::find($course_id);
			if($course){

				if($teacher->courses()->find($course->id)){

					// First remove all the students...
					$course->students()->detach();

					// Then delete the course...
					$course->delete();

					// Finalize...
					return $this->createSuccessResponse("The course with id {$course_id} 
					has been successfully removed.", 204);
				}

				return $this->createErrorResponse("The course with id {$course_id} is not associated 
				with teacher with id {$teacher_id}.", 409);
			}

			return $this->createErrorResponse("The course with id {$course_id} has not been found.", 404);
		}

		return $this->createErrorResponse("The teacher with id {$teacher_id} has not been found.", 404);
	}

	private function validateRequest($request){

		$this->validate($request, $this->rules);
	}
}