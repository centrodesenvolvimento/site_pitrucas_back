<?php

namespace App\Http\Controllers;

use App\Models\HomeContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class HomeContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $homeContents = HomeContent::all();
        $homeContents = $homeContents->map(function ($homeContent) {
            return [
                'id' => $homeContent->id,
                'videoInicial' => $homeContent->videoInicial ? str_replace('/storage/', '/public/storage/', asset('storage/videos/').'/'. $homeContent->videoInicial) : null,
                'imagemPr' => $homeContent->imagemPr ? str_replace('/storage/', '/public/storage/', asset('storage/images/' . $homeContent->imagemPr)) : null,
                'perfilPr' => $homeContent->perfilPr,
                'mensagemPr' => $homeContent->mensagemPr,
                'testemunhos' => $homeContent->testemunhos,
                'created_at' => $homeContent->created_at,
                'updated_at' => $homeContent->updated_at,
            ];
        });

        return response()->json($homeContents);
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
        $homeContents = HomeContent::findOrFail($id);
        return response()->json($homeContents);
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
        $homeContent = HomeContent::findOrFail($id);
        if ($field == 'image'){
            if($request->image_data){
                $imageData = base64_decode($request->input('image_data'));
                // $imageData = $request->file('image_data');
                $filename = 'image_'.time(). '.jpeg';
                //$imagePath = "images/".$filename;
                $imagePath = "images/" . $filename;



                Storage::disk('public')->put($imagePath, $imageData);

                if ($homeContent->imagemPr) {
                    Storage::disk('public')->delete('images/'.$homeContent->imagemPr);
                }
                $homeContent->imagemPr = $filename;
                $homeContent->save();
            }

        }else if ($field == 'video') {
            $file = $request->file('video_data');
            $filename = 'video_' . time() . '.'. 'mp4';
            $videoPath = "videos/" . $filename;

            // Storage::disk('public')->put($videoPath, file_get_contents($file));
            Storage::disk('public')->putFileAs('videos', $file, $filename);



            if ($homeContent->videoInicial) {
                Storage::disk('public')->delete('videos/'.$homeContent->videoInicial);
            }
            $homeContent->videoInicial = $filename;
            $homeContent->save();

        }else if ($field == 'mensagem'){
            $homeContent = HomeContent::findOrFail($id);
            $homeContent->mensagemPr = $request->input('mensagem');
            $homeContent->save();
        }else if ($field == 'testemunhos') {
            $homeContent->testemunhos = $request->input('testemunhos');
            $homeContent->save();
        }else {
            // $homeContent->fill($request->all());
            if($request->image_data){
                $imageData = base64_decode($request->input('image_data'));
                // $imageData = $request->file('image_data');
                $filename = 'image_'.time(). '.jpeg';
                //$imagePath = "images/".$filename;
                $imagePath = "images/" . $filename;



                Storage::disk('public')->put($imagePath, $imageData);

                if ($homeContent->imagemPr) {
                    Storage::disk('public')->delete('images/'.$homeContent->imagemPr);
                }
                $homeContent->imagemPr = $filename;
            }
            if ($request->mensagemPr){
                $homeContent->mensagemPr = $request->input('mensagemPr');
            }
            if ($request->perfilPr){
                $homeContent->perfilPr = $request->input('perfilPr');
            }
            if ($request->video_data){
                $file = $request->file('video_data');
                $filename = 'video_' . time() . '.mp4';
                $videoPath = "videos/" . $filename;

                Storage::disk('public')->put($videoPath, file_get_contents($file));


                if ($homeContent->videoInicial) {
                    Storage::disk('public')->delete('videos/'.$homeContent->videoInicial);
                }
                $homeContent->videoInicial = $filename;
            }
            $homeContent->save();


        }

        return response()->json(['message' => 'Home content updated successfully', 'data'=> $homeContent]);
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
