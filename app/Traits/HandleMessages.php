<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Throwable;

trait HandleMessages
{
    public function handleErrors(Throwable $th){
        return response()->json(
            [
                "data"=>"Ocorreu um erro ao processar sua solicitação. Tente novamente mais tarde",
                "error"=>$th->getMessage(),
                "trace"=>$th->getTrace()
            ]
        ,Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function defaultJsonReturn($code,$message,$params=[]){
        return response()->json(["data"=>__($message,$params)],$code);
    }
}
