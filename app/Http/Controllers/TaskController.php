<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\TaskModel;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
	public function __construct()
	{
    	$this->middleware('jwt.auth');
	} 
	     
    public function admin()
    {
		$tasks = $this->_getAllTasks();
        return view('tasks',array('items'=>$tasks));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     public function index()
	 {
		$tasks = $this->_getAllTasks();
		return response()->json(['status'=>'success','count'=>count($tasks),'items'=>$tasks]);
	 }
	 
    public function store(Request $request)
    {
        $json = $request->all();
		unset($json['id']);
		$json['userID'] = $this->getAuthenticatedUser()->id;
		TaskModel::create($json);
		return response()->json(array('status'=>'success'));
		
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$json = $request->all();
		unset($json['id']);
		
		TaskModel::where('id', $id)
		->update($json);
		
      	return response()->json(array('status'=>'success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
		TaskModel::destroy($id);
       	return response()->json(array('status'=>'success'));
    }
	
	private function _getAllTasks() {
		$tasks = TaskModel::where('userID',$this->getAuthenticatedUser()->id)
			->where('done',0)
			->orderBy(\DB::raw('ISNULL(duedate)'), 'ASC')
			->orderBy('duedate','asc')
			->get();
		
		foreach($tasks as $i=>$task) {
			if($task->duedate) {
				$tasks[$i]['duedate'] = date('Y-m-d\TH:i:s',strtotime($task->duedate));
			}
		}
		return $tasks;
	}
	
	private function getAuthenticatedUser()
	{
	    try {
	
	        if (! $user = JWTAuth::parseToken()->authenticate()) {
	            return response()->json(['user_not_found'], 404);
	        }
	
	    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
	
	        return response()->json(['token_expired'], $e->getStatusCode());
	
	    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
	
	        return response()->json(['token_invalid'], $e->getStatusCode());
	
	    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
	
	        return response()->json(['token_absent'], $e->getStatusCode());
	
	    }
	
	    // the token is valid and we have found the user via the sub claim
	    return $user;
	}
}
