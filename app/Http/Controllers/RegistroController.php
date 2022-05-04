<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use Illuminate\Http\Request;

class RegistroController extends Controller
{
    /**
     * Crea un registro
     * @param Request $request
     * @return json
     * @author David Peláez
     */
    public function guardar(Request $request){

        try{

            $request->validate([
                'nombre' => 'required|string|max:255',
                'correo' => 'required|email|max:255',
                'celular' => 'required|integer|digits_between:10,13',
                'edad' => 'required|integer|between:18,100',
                'viaje_en' => 'required|string|max:255'
            ]);
            
            $nickname = explode('@', $request->correo)[0];
            /** Validamos que el nickname no exista */
            if(Registro::where('nickname', $nickname)->exists()){
                return response()->json('El nickname ya esta en uso.', 302);
            }

            $registro = new Registro;
            $registro->nombre = $request->nombre;
            $registro->correo = $request->correo;
            $registro->celular = $request->celular;
            $registro->edad = $request->edad;
            $registro->nickname = $nickname;
            $registro->viaje_en = $request->viaje_en;
            $registro->save();
            return response()->json($registro, 201);

        }catch(\Exception $e){
            return response()->json($e->getMessage(), $e->status);
        }
    }
}
