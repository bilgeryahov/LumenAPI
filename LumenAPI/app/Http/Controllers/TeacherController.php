<?php

namespace  App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller{

	private $rules = [
		'name' => 'required',
		'phone' => 'required|numeric',
		'address' => 'required',
		'profession' => 'required|in:engineering,math,physics'
	];

	public function index(){

		$teachers = Teacher::All();

		return $this->createSuccessResponse($teachers, 200);
	}

	public function show($id){

		$teacher = Teacher::find($id);

		if($teacher){

			return $this->createSuccessResponse($teacher, 200);
		}

		return $this->createErrorResponse("The teacher with id {$id} does not exist!", 404);
	}

	public function store(Request $request){

		$this->validateRequest($request);

		// If we successfully pass validation.
		$teacher = Teacher::create($request->all());

		return $this->createSuccessResponse("Teacher with id {$teacher->id} has been successfully 
		created" , 201);
	}

	public function update(Request $request, $teacher_id){

		$teacher = Teacher::find($teacher_id);

		if($teacher){

			$this->validateRequest($request);

			// If we successfully pass validation.
			$teacher->name = $request->get('name');
			$teacher->phone = $request->get('phone');
			$teacher->address = $request->get('address');
			$teacher->profession = $request->get('profession');

			$teacher->save();

			return $this->createSuccessResponse("Teacher with id {$teacher->id} 
			has been successfully modified", 204);
		}

		return $this->createErrorResponse("The teacher with id {$teacher_id} does not exist", 404);
	}

	public function destroy($teacher_id){

		$teacher = Teacher::find($teacher_id);

		if($teacher){

			$courses = $teacher->courses;
			if(sizeof($courses) > 0){

				return $this->createErrorResponse('You cannot remove teacher with active courses. Remove the 
				courses first.', 409);
			}

			$teacher->delete();
			return $this->createSuccessResponse("Teacher with id {$teacher_id} has been successfully 
			 deleted", 204);
		}

		return $this->createErrorResponse("The teacher with id {$teacher_id} does not exist", 404);
	}

	private function validateRequest($request){

		$this->validate($request, $this->rules);
	}
}