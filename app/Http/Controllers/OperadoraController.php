<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Operator as Operadora;
use App\Fare as Taxa;

class OperadoraController extends Controller
{
    public function store(Request $request){

        try{
            // Instanciar objeto operadora
            $operadora = Operadora::where('code', 'like', "%{$request->operadora}%")->first();

            if (empty($operadora)){
                $operadora = new Operadora();
                $operadora->code = $request->input('operadora');
                $operadora->save();

                return response()->json(['status' => 'success', 'title' => 'Sucesso!', 'message' => 'Operadora '.$operadora->id.' cadastrada.']);
            }else{
                return response()->json(['status' => 'warning', 'title' => 'Atenção!', 'message' => 'Operadora '.$operadora->id.' já cadastrada.']);
            }
        }catch(Exception $e){
            \Log::info($e->getMessage());
        }

    }
}
