<?php

namespace  App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller{

	private $rules = [
		'name' => 'required',
		'phone' => 'required|numeric',
		'address' => 'required',
		'career' => 'required|in:engineering,math,physics'
	];

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

	public function store(Request $request){

		$this->validateRequest($request);

		// If we successfully pass validation.
		$student = Student::create($request->all());

		return $this->createSuccessResponse("Student with id {$student->id} has been successfully 
		created" , 201);
	}

	public function update(Request $request, $student_id){

		$student = Student::find($student_id);

		if($student){

			$this->validateRequest($request);

			// If we successfully pass validation.
			$student->name = $request->get('name');
			$student->phone = $request->get('phone');
			$student->address = $request->get('address');
			$student->career = $request->get('career');

			$student->save();

			return $this->createSuccessResponse("Student with id {$student->id} 
			has been successfully modified", 204);
		}

		return $this->createErrorResponse("The student with id {$student_id} does not exist", 404);
	}

	public function destroy(){

		return __METHOD__;
	}

	private function validateRequest($request){

		$this->validate($request, $this->rules);
	}
}