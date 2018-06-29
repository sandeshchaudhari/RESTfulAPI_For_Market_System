<?php
namespace App\Traits;

//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser{


    private function successResponse($data,$code){
        return response()->json($data,$code);
    }
    protected function errorResponse($message,$code){
        return response()->json(['error'=>$message,'code'=>$code],$code);
    }
    protected function showAll(Collection $collection,$code=200){
        if($collection->isEmpty()){
            //Transformer atomatically adds data field in response so we need
            // not to add data field in response
            return $this->successResponse($collection,$code);
        }
        $transformer=$collection->first()->transformer;
        $collection=$this->transformData($collection,$transformer);
        //Transformer atomatically adds data field in response so we need
        // not to add data field in response
        return $this->successResponse($collection,$code);
    }

    /**
     * @param Model $model
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showOne(Model $model, $code=200){
        $transformer=$model->transformer;
        $model=$this->transformData($model,$transformer);
        //Transformer atomatically adds data field in response so we need
        // not to add data field in response
        return $this->successResponse($model,$code);

    }
    protected function showMessage($message,$code){
        return $this->successResponse(['data'=>$message],$code);
    }
    protected function transformData($data,$transformer){
        $transformation=fractal($data,new $transformer);
        return $transformation->toArray();
    }
}