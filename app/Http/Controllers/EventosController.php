<?php

namespace App\Http\Controllers;

use App\Models\Eventos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)

    {
        $limit = $request->query('limit');
        if ($limit){
            $events = Eventos::orderBy('created_at', 'desc')->take($limit)->get();
        }else {
            $events = Eventos::orderBy('created_at', 'desc')->get();
        }
        $events = $events->map(function ($event) {
            return array_merge(json_decode($event, true), [
                'polo' => $event->polo,
                'info' => array_merge($event->info, [
                    'imagem' => $event->info['imagem']

                ])
            ]);
        });

        return response()->json($events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addEvent(Request $request)
    {
        //
        $imageData = base64_decode($request->input('image_data'));
        $filename = 'image_'.time(). '.jpeg';
        $imagePath = "images/" . $filename;
        Storage::disk('public')->put($imagePath, $imageData);
        // asset('storage/images/').'/'.
        $newObj = [
            'imagem'=> $filename,
            'titulo' => $request->input('titulo'),
            'mesmo_dia' => $request->input('mesmo_dia'),
            'iniDate' => $request->input('iniDate'),
            'finalDate' => $request->input('finalDate'),
            'horario' => $request->input('horario'),
            'publico' => $request->input('publico'),
            'descricao' => $request->input('descricao'),
            'localizacao' => $request->input('localizacao'),
            'tipo' => $request->input('tipo'),
            'iframe' => $request->input('iframe')
        ];
        Eventos::create([
            'polo' => $request->input('polo'),
            'info'=> $newObj,
        ]);
        return response()->json($newObj);
    }

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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $departamento = Eventos::findOrFail($id);
        if ($request->image_data){
            // Storage::disk('public')->delete(str_replace('/storage', '', parse_url($request->imagem)));
            Storage::disk('public')->delete('images/'.$request->imagem);
            $imageData = base64_decode($request->input('image_data'));
            $filename = 'image_'.time(). '.jpeg';
            $imagePath = "images/" . $filename;
            // asset('storage/images/').'/'.
            Storage::disk('public')->put($imagePath, $imageData);
            $newObj = [
                'imagem'=> $filename,
                'titulo' => $request->input('titulo'),
                'mesmo_dia' => $request->input('mesmo_dia'),
                'iniDate' => $request->input('iniDate'),
                'finalDate' => $request->input('finalDate'),
                'horario' => $request->input('horario'),
                'publico' => $request->input('publico'),
                'descricao' => $request->input('descricao'),
                'localizacao' => $request->input('localizacao'),
                'tipo' => $request->input('tipo'),
                'iframe' => $request->input('iframe'),
                'show' => $request->input('show')

            ];
            $departamento->polo = $request->input('polo');

            $departamento->info = $newObj;
            $departamento->save();
        }else {
            $newObj = [
                'imagem'=> $request->input('imagem'),
                'titulo' => $request->input('titulo'),
                'mesmo_dia' => $request->input('mesmo_dia'),
                'iniDate' => $request->input('iniDate'),
                'finalDate' => $request->input('finalDate'),
                'horario' => $request->input('horario'),
                'publico' => $request->input('publico'),
                'descricao' => $request->input('descricao'),
                'localizacao' => $request->input('localizacao'),
                'tipo' => $request->input('tipo'),
                'iframe' => $request->input('iframe'),
                'show' => $request->input('show')

            ];
            $departamento->info = $newObj;
            $departamento->polo = $request->input('polo');

            $departamento->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        // Storage::disk('public')->delete(str_replace('/storage', '', parse_url($request->imagem)));
        Storage::disk('public')->delete('images/'.$request->imagem);
        $departamento = Eventos::findOrFail($id);
        $departamento->delete();

    }
}