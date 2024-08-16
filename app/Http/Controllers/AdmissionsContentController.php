<?php

namespace App\Http\Controllers;

use App\Models\AdmissionsContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdmissionsContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $admissionsContents = AdmissionsContent::all();
        $admissionsContents = $admissionsContents->map(function ($admissionsContent) {
            return [
                'id' => $admissionsContent->id,
                'emolumentos' => $admissionsContent->emolumentos,
                'calendario' => $admissionsContent->calendario,
                'exames' => $admissionsContent->exames,
                'perguntas' => $admissionsContent->perguntas,
                'created_at' => $admissionsContent->created_at,
                'updated_at' => $admissionsContent->updated_at,
            ];
        });

        return response()->json($admissionsContents);
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
        $admissionsContent = AdmissionsContent::findOrFail($id);

        if ($field == 'exames') {
            if ($request->edit){
                if ($request->newDocumento) {
                    Storage::disk('public')->delete('pdfs/'.$request->documento);
                    $file = $request->file('newDocumento');
                    $filename = 'pdf' . time() . '.'. 'pdf';
                    Storage::disk('public')->putFileAs('pdfs', $file, $filename);
                    $newList = array_map(function ($item) use ($request, $filename){
                        if ($item['id'] == $request->id){
                            $item['id'] = $request->input('id');
                            $item['nome'] = $request->input('nome');
                            $item['data'] = $request->input('data');
                            $item['documento'] = $filename;
                            $item['show'] = $request->input('show');
                        }
                        return $item;
                    }, $admissionsContent->exames);
                    $admissionsContent->exames = $newList;
                    $admissionsContent->save();
                    return response()->json(['newList'=>$newList]);

                }else {

                    $admissionsContent->exames = $request->input('documentos');
                    $admissionsContent->save();
                    return response()->json(['dataNoNew'=>$request->all()]);
                }
            }else {
                if ($request->delete){
                    Storage::disk('public')->delete('pdfs/'.$request->documento);
                    $newList = array_filter($admissionsContent->exames, function ($item) use ($request) {
                        return $item['id'] != $request->id;
                    });
                    $admissionsContent->exames = $newList;
                    $admissionsContent->save();
                    return response()->json(['data'=>$newList]);

                }else {
                    $list = $admissionsContent->exames;
                    $length = count($admissionsContent->exames);
                    $file = $request->file('documento');
                    $filename = 'pdf' . time() . '.'. 'pdf';
                    Storage::disk('public')->putFileAs('pdfs', $file, $filename);
                    // $aboutContent->organigrama = asset('storage/pdfs/').'/'.$filename;
                    $newObj = [
                        'id' => $length + 1,
                        'nome' => $request->input('nome'),
                        'data' => $request->input('data'),
                        'documento' =>$filename
                    ];
                    array_unshift($list, $newObj);
                    $admissionsContent->exames = $list;
                    $admissionsContent->save();
                    return response()->json(['data' => $request->all()]);
                }
            }
        }else {
            if ($request->hasFile('emolumentos')){
                if ($request->pdf){
                    Storage::disk('public')->delete('pdfs/'.$request->pdf);
                    $file = $request->file('emolumentos');
                    $filename = 'pdf' . time() . '.'. 'pdf';

                    // Storage::disk('public')->put($videoPath, file_get_contents($file));
                    Storage::disk('public')->putFileAs('pdfs', $file, $filename);
                    $admissionsContent->emolumentos = $filename;
                    $admissionsContent->save();
                    return response()->json(['data'=> $request->all()]);
                }else {
                    $file = $request->file('emolumentos');
                    $filename = 'pdf' . time() . '.'. 'pdf';

                    // Storage::disk('public')->put($videoPath, file_get_contents($file));
                    Storage::disk('public')->putFileAs('pdfs', $file, $filename);
                    $admissionsContent->emolumentos = $filename;
                    $admissionsContent->save();
                    return response()->json(['data'=> $request->all()]);

                }
            }
            if ($request->hasFile('calendario')){
                if ($request->pdf){
                    Storage::disk('public')->delete('pdfs/'.$request->pdf);
                    $file = $request->file('calendario');
                    $filename = 'pdf' . time() . '.'. 'pdf';

                    // Storage::disk('public')->put($videoPath, file_get_contents($file));
                    Storage::disk('public')->putFileAs('pdfs', $file, $filename);
                    $admissionsContent->calendario = $filename;
                    $admissionsContent->save();
                    return response()->json(['data'=> $request->all()]);
                }else {
                    $file = $request->file('calendario');
                    $filename = 'pdf' . time() . '.'. 'pdf';

                    // Storage::disk('public')->put($videoPath, file_get_contents($file));
                    Storage::disk('public')->putFileAs('pdfs', $file, $filename);
                    $admissionsContent->calendario = $filename;
                    $admissionsContent->save();
                    return response()->json(['data'=> $request->all()]);

                }
            }
            if ($request->perguntas){
                $admissionsContent->perguntas = $request->input('perguntas');
                $admissionsContent->save();
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
