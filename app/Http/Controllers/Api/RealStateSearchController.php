<?php

namespace App\Http\Controllers\Api;

use App\Repository\RealStateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RealState;
use Api\ApiMessage;

class RealStateSearchController extends Controller
{
    
    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }


    public function index(Request $request)
    {
        $repository = new RealStateRepository($this->realState);

	    if($request->has('conditions')) {
		    $repository->selectConditions($request->get('conditions'));
        }
        
	    if($request->has('fields')) {
		    $repository->selectFilter($request->get('fields'));
        }
        
        $repository->setLocation($request->all(['state', 'city']));
        
        return response()->json([
        	'data' => $repository->getResult()->with('photos')->paginate(10)
        ], 200);

    }

  
   
    public function show($id)
    {
        try{

            $realState = $this->realState->with('address')->with('photos')->findOrFail($id);

            return response()->json([
                'data' => $realState
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessage($e->getMessage());

            return reponse()->json($message->getMessage(), 401);
        }
    } 
   
   
}
