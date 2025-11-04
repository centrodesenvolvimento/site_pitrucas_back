<?php

namespace App\Http\Controllers;

use App\Models\AboutContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $aboutContents = AboutContent::all();
        $aboutContents = $aboutContents->map(function ($aboutContent) {
            return [
                'id' => $aboutContent->id,
                'video' => $aboutContent->video ? str_replace('/storage/', '/public/storage/', asset('storage/videos/').'/'. $aboutContent->video) : null,
                'somos' => $aboutContent->somos,
                'missao' => $aboutContent->missao,
                'visao' => $aboutContent->visao,
                'valores'=> $aboutContent->valores,
                'orgaos_singulares'=> $aboutContent->orgaos_singulares,
                'orgaos_colegiais'=> $aboutContent->orgaos_colegiais,
                'administracao'=> $aboutContent->administracao,
                'historial'=> $aboutContent->historial,
                'organigrama'=> $aboutContent->organigrama,
                'regulamentos'=> $aboutContent->regulamentos,



                'created_at' => $aboutContent->created_at,
                'updated_at' => $aboutContent->updated_at,
            ];
        });

        return response()->json($aboutContents);
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
        //
        $aboutContent = AboutContent::findOrFail($id);
        if ($field == 'valores'){
            $aboutContent->valores = $request->input('valores');
            $aboutContent->save();
        } else if ($field == 'singulares'){
            if ($request->presidente == true){
                $list = $aboutContent->orgaos_singulares;
                $length = count($aboutContent->orgaos_singulares);

                $imageData = base64_decode($request->input('image_data'));
                $filename = 'image_'.time(). '.jpeg';
                $imagePath = "images/" . $filename;
                Storage::disk('public')->put($imagePath, $imageData);
                // asset('storage/images/').'/'
                $newObj = [
                    'id' => $length + 1,
                    'cargo' => $request->input('cargo'),
                    'presidente' => $request->input('presidente'),
                    'nome' => $request->input('nome'),
                    'descricao' => $request->input('descricao'),
                    'imagem' => $filename,
                    'hasMembers' => false,
                ];
                array_unshift($list, $newObj);
                $aboutContent->orgaos_singulares = $list;
                $aboutContent->save();
            }else {
                $list = $aboutContent->orgaos_singulares;
                $length = count($aboutContent->orgaos_singulares);
                $newObj = [
                    'id' => $length + 1,
                    'cargo' => $request->input('cargo'),
                    'descricao' => $request->input('descricao'),
                    'hasMembers' => $request->input('hasMembers'),
                    'membros' => $request->input('membros')
                ];
                array_unshift($list, $newObj);
                $aboutContent->orgaos_singulares = $list;
                $aboutContent->save();
            }
        } else if ($field == 'colegiais'){
            if ($request->has('add_member')){
                $item = current(array_filter($aboutContent->orgaos_colegiais, function ($item) use ($request) {
                    return $item['id'] == $request->id;
                }));
                $list = $item['membros']? $item['membros'] : [];
                $length = count($list);
                $imageData = base64_decode($request->input('base64Data'));
                $filename = 'image_'.time(). '.jpeg';
                $imagePath = "images/" . $filename;
                Storage::disk('public')->put($imagePath, $imageData);
                $newObj = [
                    'id' => $length + 1,
                    'cargo' => $request->input('cargo'),
                    'nome' => $request->input('nome'),
                    'imagem' => $filename,
                ];
                array_unshift($list, $newObj);
                $item['membros'] = $list;
                $newList = array_map(function ($item1) use ($request, $item){
                    if ($item1['id'] == $request->id){
                        $item1 = $item;
                    }
                    return $item1;
                }, $aboutContent->orgaos_colegiais);
                // return response()->json($newList);
                $aboutContent->orgaos_colegiais = $newList;

                $aboutContent->save();
                return response()->json($newList);

            }
            if ($request->has('delete_member')){
                $item = current(array_filter($aboutContent->orgaos_colegiais, function ($item) use ($request) {
                    return $item['id'] == $request->id;
                }));
                Storage::disk('public')->delete('images/'.$request->imagem);
                $item['membros'] = $request->input('newList');
                $newList = array_map(function ($item1) use ($request, $item){
                    if ($item1['id'] == $request->id){
                        $item1 = $item;
                    }
                    return $item1;
                }, $aboutContent->orgaos_colegiais);
                // return response()->json($newList);
                $aboutContent->orgaos_colegiais = $newList;
                $aboutContent->save();
                // return response()->json(['data'=>$aboutContent]);


            }
            $aboutContent->orgaos_colegiais = $request->input('orgaos_colegiais') ? $request->input('orgaos_colegiais') : [];

            $aboutContent->save();
            return response()->json(['data'=>$aboutContent]);
        }else if ($field == 'regulamentos') {
            if ($request->edit){
                if ($request->newDocumento) {
                    Storage::disk('public')->delete('pdfs/'.$request->documento);

                    $file = $request->file('newDocumento');
                    $filename = 'pdf' . time() . '.'. 'pdf';
                    Storage::disk('public')->putFileAs('pdfs', $file, $filename);
                    $newList = array_map(function ($item) use ($request, $filename){
                        if ($item['id'] == $request->id){
                            $item['id'] = $request->input('id');
                            $item['titulo'] = $request->input('titulo');
                            $item['data'] = $request->input('data');
                            $item['documento'] = $filename;
                            $item['show'] = $request->input('show');
                        }
                        return $item;
                    }, $aboutContent->regulamentos);
                    $aboutContent->regulamentos = $newList;
                    $aboutContent->save();
                    return response()->json(['newList'=>$newList]);

                }else {

                    $aboutContent->regulamentos = $request->input('documentos');
                    $aboutContent->save();
                    return response()->json(['dataNoNew'=>$request->all()]);
                }
            }else {
                if ($request->delete){
                    Storage::disk('public')->delete('pdfs/'.$request->documento);
                    $newList = array_filter($aboutContent->regulamentos, function ($item) use ($request) {
                        return $item['id'] != $request->id;
                    });
                    $aboutContent->regulamentos = $newList;
                    $aboutContent->save();
                    return response()->json(['data'=>$newList]);

                }else {
                    $list = $aboutContent->regulamentos;
                    $length = count($aboutContent->regulamentos);
                    $file = $request->file('documento');
                    $filename = 'pdf' . time() . '.'. 'pdf';
                    Storage::disk('public')->putFileAs('pdfs', $file, $filename);
                    // $aboutContent->organigrama = asset('storage/pdfs/').'/'.$filename;
                    $newObj = [
                        'id' => $length + 1,
                        'titulo' => $request->input('titulo'),
                        'data' => $request->input('data'),
                        'documento' => $filename
                    ];
                    array_unshift($list, $newObj);
                    $aboutContent->regulamentos = $list;
                    $aboutContent->save();
                    return response()->json(['data' => $request->all()]);
                }
            }
        }else {
            if ($request->somos){
                $aboutContent->somos = $request->input('somos');
                $aboutContent->save();
            }
            if ($request->video_data){
                $file = $request->file('video_data');
                $filename = 'video_' . time() . '.'. 'mp4';
                $videoPath = "videos/" . $filename;

                // Storage::disk('public')->put($videoPath, file_get_contents($file));
                Storage::disk('public')->putFileAs('videos', $file, $filename);
                // if ($aboutContent->video) {
                //     Storage::disk('public')->delete('videos/'.$aboutContent->video);
                // }
                $aboutContent->video = $filename;
                $aboutContent->save();

            }
            if ($request->missao){
                $aboutContent->missao = $request->input('missao');
            }
            if ($request->visao){
                $aboutContent->visao = $request->input('visao');
            }
            if ($request->has('add_member')){
                $item = current(array_filter($aboutContent->orgaos_singulares, function ($item) use ($request) {
                    return $item['id'] == $request->id;
                }));
                $list = $item['membros']? $item['membros'] : [];
                $length = count($list);
                $imageData = base64_decode($request->input('base64Data'));
                $filename = 'image_'.time(). '.jpeg';
                $imagePath = "images/" . $filename;
                Storage::disk('public')->put($imagePath, $imageData);
                $newObj = [
                    'id' => $length + 1,
                    'cargo' => $request->input('cargo'),
                    'nome' => $request->input('nome'),
                    'imagem' => $filename,
                ];
                array_unshift($list, $newObj);
                $item['membros'] = $list;
                $newList = array_map(function ($item1) use ($request, $item){
                    if ($item1['id'] == $request->id){
                        $item1 = $item;
                    }
                    return $item1;
                }, $aboutContent->orgaos_singulares);
                // return response()->json($newList);
                $aboutContent->orgaos_singulares = $newList;
                $aboutContent->save();

            }
            if ($request->has('delete_member')){
                $item = current(array_filter($aboutContent->orgaos_singulares, function ($item) use ($request) {
                    return $item['id'] == $request->id;
                }));
                Storage::disk('public')->delete('images/'.$request->imagem);
                $item['membros'] = $request->input('newList');
                $newList = array_map(function ($item1) use ($request, $item){
                    if ($item1['id'] == $request->id){
                        $item1 = $item;
                    }
                    return $item1;
                }, $aboutContent->orgaos_singulares);
                // return response()->json($newList);
                $aboutContent->orgaos_singulares = $newList;
                $aboutContent->save();
                // return response()->json(['data'=>$request->imagem]);


            }


            if ($request->has('orgaos_singulares')){

                if ($request->has('image_data')){
                    $list = $aboutContent->orgaos_singulares;
                    $imageData = base64_decode($request->input('image_data'));
                    $filename = 'image_'.time(). '.jpeg';
                    $imagePath = "images/" . $filename;
                    $parsedUrl = parse_url($request->imagem);
                    $filename1 = basename($parsedUrl['path']); // Extract 'filename.jpg'
                    $imagePath1 = 'images/' . $filename1;
                    Storage::disk('public')->delete('images/'.$request->imagem);


                    Storage::disk('public')->put($imagePath, $imageData);
                    $newList = array_map(function ($item) use ($request, $filename){
                        if ($item['id'] == $request->id){
                            $item['id'] = $request->id;
                            $item['cargo'] = $request->input('cargo');
                            $item['presidente'] = $request->input('presidente');
                            $item['nome'] = $request->input('nome');
                            $item['descricao'] = $request->input('descricao');
                            $item['imagem'] = $filename;
                            $item['hasMembers'] = false;
                            $item['show'] = $request->input('show');
                        }
                        return $item;
                    }, $list);
                    $aboutContent->orgaos_singulares = $newList;
                    $aboutContent->save();
                    return response()->json(['data'=> $newList]);
                    // $aboutContent->save();
                }else {

                    $aboutContent->orgaos_singulares = $request->input('orgaos_singulares');
                    $aboutContent->save();
                }

            }
            if ($request->has('administracao')){
                $aboutContent->administracao = $request->input('administracao');
                $aboutContent->save();

                return response()->json(['data'=> $request->administracao]);
            }
            if ($request->has('historial')){
                $aboutContent->historial = $request->input('historial');
                $aboutContent->save();

                return response()->json(['data'=> $request->historial]);
            }
            if ($request->hasFile('organigrama')){
                if ($request->pdf){
                    Storage::disk('public')->delete('pdfs/'.$request->pdf);
                    $file = $request->file('organigrama');
                    $filename = 'pdf' . time() . '.'. 'pdf';

                    // Storage::disk('public')->put($videoPath, file_get_contents($file));
                    Storage::disk('public')->putFileAs('pdfs', $file, $filename);
                    $aboutContent->organigrama = $filename;
                    $aboutContent->save();
                    return response()->json(['data'=> $request->all()]);
                }else {
                    $file = $request->file('organigrama');
                    $filename = 'pdf' . time() . '.'. 'pdf';

                    // Storage::disk('public')->put($videoPath, file_get_contents($file));
                    Storage::disk('public')->putFileAs('pdfs', $file, $filename);
                    $aboutContent->organigrama = $filename;
                    $aboutContent->save();
                    return response()->json(['data'=> $request->all()]);

                }
            }

            $aboutContent->save();
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
