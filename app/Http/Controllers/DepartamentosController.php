<?php

namespace App\Http\Controllers;

use App\Models\Departamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DepartamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $all = Departamentos::orderBy('id', 'asc')->get();
        $departamentos = $all->map(function ($departamento) {
            return [
                'id' => $departamento->id,
                'info' => $departamento->info,
                'cursos' => $departamento->cursos,
                'created_at' => $departamento->created_at,
                'updated_at' => $departamento->updated_at,
            ];
        });
        return response()->json($departamentos);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        $departamento = Departamentos::findOrFail($id);
        $obj = [
            'id' => $departamento->id,
            'info' => $departamento->info,
            'cursos' => $departamento->cursos,
            'created_at' => $departamento->created_at,
            'updated_at' => $departamento->updated_at,
        ];
        return response()->json($obj);


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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $field, $id)
    {
        $departamento = Departamentos::findOrFail($id);
        if ($field == 'info'){
            if ($request->video_data){

                Storage::disk('public')->delete('videos/'.$request->video);
                $file = $request->file('video_data');
                $filename = 'department_video_' . time() . '.'. '.mp4';
                Storage::disk('public')->putFileAs('videos', $file, $filename);
                $newObj = [
                    'titulo'=> $request->input('titulo'),
                    'video' =>  $filename,
                    'descricao' => $request->input('descricao'),
                    'saidas' => $request->input('saidas'),
                    'imagem' => $request->input('imagem'),
                ];
                if ($request->image_data){
                    Storage::disk('public')->delete('images/'.$request->imagem);
                    $imageData = base64_decode($request->input('image_data'));
                    $filename1 = 'image_'.time(). '.jpeg';
                    $imagePath1 = "images/" . $filename1;
                    Storage::disk('public')->put($imagePath1, $imageData);
                    $newObj = [
                        'titulo'=> $request->input('titulo'),
                        'video' => $filename,
                        'descricao' => $request->input('descricao'),
                        'saidas' => $request->input('saidas'),
                        'imagem' => $filename1,
                    ];
                }
                $departamento->info = $newObj;
                $departamento->save();
                return response()->json(['data1'=>$request->all()]);
            }else {

                $newObj = [
                    'titulo'=> $request->input('titulo'),
                    'video' =>  $request->input('video'),
                    'descricao' => $request->input('descricao'),
                    'saidas' => $request->input('saidas'),
                    'imagem' => $request->input('imagem'),
                ];
                if ($request->image_data){
                    Storage::disk('public')->delete('images/'.$request->imagem);
                    $imageData = base64_decode($request->input('image_data'));
                    $filename1 = 'image_'.time(). '.jpeg';
                    $imagePath1 = "images/" . $filename1;
                    Storage::disk('public')->put($imagePath1, $imageData);
                    $newObj = [
                        'titulo'=> $request->input('titulo'),
                        'video' =>  $request->input('video'),
                        'descricao' => $request->input('descricao'),
                        'saidas' => $request->input('saidas'),
                        'imagem' => $filename1,
                    ];
                }
                $departamento->info = $newObj;
                $departamento->save();
                return response()->json(['data'=>$request->all()]);

            }
        }else if ($field == 'curso'){
            if ($request->addCurso) {
                $imageData = base64_decode($request->input('image_data'));
                $filename = 'image_'.time(). '.jpeg';
                $imagePath = "images/" . $filename;
                Storage::disk('public')->put($imagePath, $imageData);
                $list = $departamento->cursos;
                $length = count($list);
                $newObj = [
                    'id' => $length + 1,
                    'anos'=> $request->input('anos'),
                    'avaliacao' => $request->input('avaliacao'),
                    'candidaturas'=> $request->input('candidaturas'),
                    'data'=> $request->input('data'),
                    'descricao'=>$request->input('descricao'),
                    'estagio'=>$request->input('estagio'),
                    'imagem'=> $filename,
                    'saidas'=> $request->input('saidas'),
                    'tipo'=> $request->input('tipo'),
                    'titulo'=> $request->input('titulo'),
                ];
                array_unshift($list, $newObj);
                $departamento->cursos = $list;
                $departamento->save();
                return response()->json(['data'=>$list]);
            }else {
                if ($request->deleteCurso){
                    Storage::disk('public')->delete('images/'.$request->imagem);
                    $departamento->cursos = $request->cursos;
                    $departamento->save();
                    return response()->json($request->all());
                }else {
                    if ($request->image_data){
                        Storage::disk('public')->delete('images/'.$request->imagem);
                        $imageData = base64_decode($request->input('image_data'));
                        $filename = 'image_'.time(). '.jpeg';
                        $imagePath = "images/" . $filename;
                        Storage::disk('public')->put($imagePath, $imageData);
                        $newList = array_map(function ($item) use ($request, $filename){
                            if ($item['id'] == $request->id){
                                $item['id'] = $request->id;
                                $item['anos']= $request->input('anos');
                                $item['avaliacao']= $request->input('avaliacao');
                                $item['candidaturas']= $request->input('candidaturas');
                                $item['data']= $request->input('data');
                                $item['descricao']=$request->input('descricao');
                                $item['estagio']=$request->input('estagio');
                                $item['imagem']= $filename;
                                $item['saidas']= $request->input('saidas');
                                $item['tipo']= $request->input('tipo');
                                $item['titulo']= $request->input('titulo');
                            }
                            return $item;
                        }, $departamento->cursos);
                        $departamento->cursos = $newList;
                        $departamento->save();
                        return response()->json(['data'=> $newList]);

                    }else {
                        $departamento->cursos = $request->input('cursos');
                        $departamento->save();
                        return response()->json(['data'=> $request->all()]);
                    }
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
