<?php

namespace App\Http\Controllers\Api;

//use Illuminate\Http\Request;

use App\Api\ApiMessage;
use App\Http\Requests\RealStateRequest;
use App\Http\Controllers\Controller;
use App\RealState;
use PhpParser\Node\Stmt\TryCatch;

class RealStateController extends Controller
{

    private $realState;

    //injetando o model RealState no construtor da classe
    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function index()
    {
        $realState = auth('api')->user()->realState();
        //$realState = $this->realState->with('categories')->paginate('10');
        
        return response()->json($realState->with('categories')->paginate('5'), 200);
    }

    public function show($id)
    {

        try{

            $realState = auth('api')->user()->realState()->with('photos')->with('categories')->findOrFail($id);

            return response()->json([
                'data' => $realState   
            ], 200);

        }catch(\Exception $e){

            $message = new ApiMessage($e->getMessage());
            return response()->json($message->getMessage(), 401);

        }

    }

    public function store(RealStateRequest $request)
    {
        $data = $request->all();
        $images = $request->file('images');

        try{

            //pega o id do usuário
            $data['user_id'] = auth('api')->user()->id;

            $realState = $this->realState->create($data);

            if(isset($data['categories']) && count($data['categories'])){
                $realState->categories()->sync($data['categories']);
            }

            if($images){

                $imagesUploaded = [];

                foreach ($images as $image){
                    $path = $image->store('img', 'public');
                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $realState->photos()->createMany($imagesUploaded);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel cadastrado com sucesso!']
            ], 200);

        }catch(\Exception $e){

            $message = new ApiMessage($e->getMessage());
            return response()->json($message->getMessage(), 401);

        }

        
    }

    public function update($id, RealStateRequest $request)
    {
        $data = $request->all();
        $images = $request->file('images');

        try{

            $realState = auth('api')->user()->realState()->findOrFail($id);
            $realState->update($data);

            if(isset($data['categories']) && count($data['categories'])){
                $realState->categories()->sync($data['categories']);
            }

            if($images){

                $imagesUploaded = [];

                foreach ($images as $image){
                    $path = $image->store('img', 'public');
                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $realState->photos()->createMany($imagesUploaded);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel atualizado com sucesso!']
            ], 200);

        }catch(\Exception $e){

            $message = new ApiMessage($e->getMessage());
            return response()->json($message->getMessage(), 401);

        }
    }

    public function destroy($id)
    {
       
        try{

            $realState = auth('api')->user()->realState()->findOrFail($id);
            $realState->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel removido com sucesso!']
            ], 200);

        }catch(\Exception $e){

            $message = new ApiMessage($e->getMessage());
            return response()->json($message->getMessage(), 401);

        }
    }
    
}
