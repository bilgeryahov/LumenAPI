<?php

namespace  App\Http\Controllers;

use App\Student;

class StudentController extends Controller{

	public function index(){

		$students = Student::All();

		return $this->createSuccessResponse($students, 200);
	}

	public function show($id){

		$student = Student::find($id);

		if($student){

			return $this->createSuccessResponse($student, 200);
		}

		return $this->createErrorResponse("The student with id {$id} does not exist!", 404);
	}

	public function store(){

		return __METHOD__;
	}

	public function update(){

		return __METHOD__;
	}

	public function destroy(){

		return __METHOD__;
	}
}