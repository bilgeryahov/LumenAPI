<?php

namespace  App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller{

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

		$rules = [
			'name' => 'required',
			'phone' => 'required|numeric',
			'address' => 'required',
			'profession' => 'required|in:engineering,math,physics'
		];

		$this->validate($request, $rules);

		// If we successfully pass validation.
		$teacher = Teacher::create($request->all());

		return $this->createSuccessResponse("Teacher with id {$teacher->id} has been successfully 
		created" , 201);
	}

	public function update(){

		return __METHOD__;
	}

	public function destroy(){

		return __METHOD__;
	}
}