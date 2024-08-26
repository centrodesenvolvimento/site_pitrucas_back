<?php

namespace App\Http\Controllers;

use App\Models\Avisos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvisosController extends Controller
{

    public function all(){
        $avisos = Avisos::all();
        return response()->json($avisos);
    }

    public function addAviso(Request $request)
    {
        //
        $imageData = base64_decode($request->input('image_data'));
        $filename = 'image_'.time(). '.jpeg';
        $imagePath = "images/" . $filename;
        Storage::disk('public')->put($imagePath, $imageData);
        // asset('storage/images/').'/'.
        $newObj = [
            'title' => $request->input('title'),
            'image' => $filename,

        ];
        Avisos::create([
            'info'=> $newObj,
        ]);
        return response()->json($newObj);
    }

    public function update(Request $request, $id)
    {
        $aviso = Avisos::findOrFail($id);
        if ($request->image_data){
            // Storage::disk('public')->delete(str_replace('/storage', '', parse_url($request->imagem)));
            Storage::disk('public')->delete('images/'.$request->imagem);
            $imageData = base64_decode($request->input('image_data'));
            $filename = 'image_'.time(). '.jpeg';
            $imagePath = "images/" . $filename;
            // asset('storage/images/').'/'.
            Storage::disk('public')->put($imagePath, $imageData);
            $newObj = [
                'title' => $request->input('title'),
                'image' => $filename,
                'show' => $request->input('show')

            ];
            $aviso->info = $newObj;
            $aviso->save();
        }else {
            $newObj = [
                'title' => $request->input('title'),
                'image' => $request->input('imagem'),
                'show' => $request->input('show')


            ];
            $aviso->info = $newObj;
            $aviso->save();
        }
    }
}
