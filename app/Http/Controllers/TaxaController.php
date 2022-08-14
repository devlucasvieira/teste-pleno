<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Operator as Operadora;
use App\Fare as Taxa;

class TaxaController extends Controller
{
    public function definirTaxa(Request $request){
        try{
            // Instanciar objeto operadora
            $operadora = Operadora::where('code', 'like', "%{$request->operadora}%")->first();

            if (empty($operadora)){
                return response()->json(['status' => 'error', 'title' => 'Erro!', 'message' => 'Operadora não encontrada']);
            }

            // Instanciar objeto com Taxas
            $taxas = Taxa::where('operator_id', $operadora->id)->where('status', 1)->get();

            if(empty($taxas)){
                return response()->json(['status' => 'warning', 'title' => 'Atenção!', 'message' => 'Operadora já possui uma taxa cadastrada', 'data' => $taxas]);
            }else{
                $taxa = new Taxa();
                $taxa->value = $request->input('tarifa');
                $taxa->operator_id = $operadora->id;
                $taxa->save();

                return response()->json(['status' => 'success', 'title' => 'Sucesso!', 'message' => 'Tarifa '.$taxa->id.' cadastrada.']);
            }
        }catch(Exception $e){
            \Log::info($e->getMessage());
        }

    }
}
