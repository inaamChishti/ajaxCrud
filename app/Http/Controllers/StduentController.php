<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stduent;
use Illuminate\Support\Facades\Validator;
class StduentController extends Controller
{
    public function index()
    {
    	return view('index');
    }
    public function save(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    		'name'=>'required',
    		'email'=>'required',
    		'phone'=>'required',
    		'course'=>'required'
    	]);
    	if($validator->fails())
    	{
    		return response()->json([
    		'status'=>400,
    		'errors'=> $validator->messages(),
    		]);
    		

    	}
    	else
    	{
    		$student = new Stduent();
    		$student->name = $request->name;
    		$student->email = $request->email;
    		$student->phone = $request->phone;
    		$student->course = $request->course;
    		$student->save();
    		return response()->json([
    			'status'=>200,
    			'message'=>'record added successfully'
    		]);
    	}
    }
    public function fetch(Request $request)
    {
    	$stduent = Stduent::all();
    	
    		return response()->json([
    		'status'=>200,
    		'student'=> $stduent,
    	]);
    	
    
    }
    public function editStudent($id = null)
    {
        $fetchRecord = Stduent::query()->where('id',$id)->first();
        if($fetchRecord)
        {
            return response()->json(['status'=>200,'data'=>$fetchRecord]);

        }
        else
        {
            return response()->json(['status'=>400,'data'=>'error']);
        }
    }
    public function updateStudent(Request $request,$id = null)
    {
        $updateStudent = Stduent::find($request->id);
        if($updateStudent)
        {
            $updateStudent->name = $request->name;
            $updateStudent->email = $request->email;
            $updateStudent->phone = $request->phone;
            $updateStudent->course = $request->course;
            $updateStudent->update();
            return response()->json([
                'success'=>200,
                'message'=>'congrats'
                ]);
        }
    }

    public function deleteStudent($id)
    {
       $dell= Stduent::query()->where('id',$id)->delete();
       if($dell)
       {
        return response()->json(['success'=>true,'message'=>'record deleted successfully']);

       }
       else
       {
        return response()->json(['success'=>false,'message'=>'Invalid']);
       }
    }
}
