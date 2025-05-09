<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    //
    function list(){
        return Student::all();
    }
       
    function addStudent(Request $request){
        $rules= array(
            'name'=>'required | min:2 | max:10',
            'email'=>'email | required',
            'phone'=>'required  |min:10 | max:10',
        );

        // HOW TO USE VALIDATION API 
        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()){
            return $validation->errors();
        }else {

            $student = new Student();
            $student->name=$request->name;
            $student->email=$request->email;
            $student->phone=$request->phone;
            $student->save();
           if($student->save()){
            return ["student" => "student added successfully"];
           }else{
            return ["student" => "Failed to add student"];
           }
        }
       
     }


     function updateStudent(Request $request){         
        $student= Student::find($request->id);
        $student->name= $request->name;
        $student->email= $request->email;
        $student->phone= $request->phone;
        if($student->save()){
            return ["student" => "student updated successfully"];
        }else {
            return ["student" => "Failed to update student"];
        }

     }


     function deleteStudent($id){
        $student = Student::destroy($id);
        if($student){
            return ['student'=>'student record deleted successfully'];
        }else {
            return ['student'=>'Failed to delete student record'];
        }
     }

     function searchStudent($name){
        $student= Student::where('name','like',"%$name%")->get();

        if ($student){
            return ['result'=>$student];
        }else {
            return ['return'=>'No results found'];
        }
     }


     
    
}
