<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $limit = $request->query('limit');
        $trend = $request->query('trend');
        if ($limit){
            if ($trend){
                $news = News::orderBy('info->views', 'desc')->take($limit)->get();
                $news = $news->map(function ($new) {
                    return [
                        'id' => $new->id,
                        'imagens' => $new->imagens,
                        'polo' => $new->polo,
                        'info' => $new->info,
                        'created_at' => $new->created_at,
                        'updated_at' => $new->updated_at,
                    ];
                });
            }else {
                $news = News::orderBy('info->data', 'desc')->take($limit)->get();
                $news = $news->map(function ($new) {
                    return [
                        'id' => $new->id,
                        'polo' => $new->polo,

                        'imagens' => $new->imagens,
                        'info' => $new->info,
                        'created_at' => $new->created_at,
                        'updated_at' => $new->updated_at,
                    ];
                });
            }

        }else {
            $news = News::orderBy('info->data', 'desc')->get();
            $news = $news->map(function ($new) {
                return [
                    'id' => $new->id,
                    'polo' => $new->polo,

                    'imagens' => $new->imagens,
                    'info' => $new->info,
                    'created_at' => $new->created_at,
                    'updated_at' => $new->updated_at,
                ];
            });
        }

        return response()->json($news);
    }
    public function get($id)
    {
        $article = News::findOrFail($id);

        return response()->json($article);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addNews(Request $request)
    {

        $list = array_map(function ($item) {
            $imageData = base64_decode($item);
            $filename = 'image_'.time(). Str::random(10). '.jpeg';
            $imagePath = "images/" . $filename;
            Storage::disk('public')->put($imagePath, $imageData);
            return $filename;
            }, $request->images_data);

        $newObj = [
            'imagens' => $list,
            'polo' => $request->input('polo'),
            'info' => [
                'titulo' => $request->input('titulo'),
                'descricao' => $request->input('descricao'),
                'data' => $request->input('data'),
                'views' => 0
            ]
        ];
        News::create($newObj);
        return response()->json($request->images_data);
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
        $news = News::findOrFail($id);
        if ($field == 'images'){
            $current = $news->imagens;
            $deleted = array_diff($current, $request->deletedImages);
            array_map(function ($item) {
                Storage::disk('public')->delete('images/'.$item);
            }, $deleted);
            $list = array_map(function ($item) {
                $imageData = base64_decode($item);
                $filename = 'image_'.time(). Str::random(10). '.jpeg';
                $imagePath = "images/" . $filename;
                Storage::disk('public')->put($imagePath, $imageData);
                return $filename;
                }, $request->newImages);
            $newList = array_merge($request->deletedImages, $list);
            $news->imagens = $newList;
            $news->info = [
                'titulo'=> $request->input('titulo'),
                
                'descricao'=> $request->input('descricao'),
                'data'=> $request->input('data'),
                'views'=> $request->input('views'),
                'show' => $request->input('show')

            ];
                        $news->polo = $request->input('polo');

            $news->save();
            return response()->json($news);
        }else {
            $newObj = [
                'titulo'=> $request->input('titulo'),
                'descricao'=> $request->input('descricao'),
                'data'=> $request->input('data'),
                'views'=> $request->input('views'),
                'show' => $request->input('show')
            ];
            $news->polo = $request->input('polo');

            $news->info = $newObj;
            $news->save();
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
        array_map(function ($item) {
            Storage::disk('public')->delete('images/'.$request->imagem);
        }, $item);
        $news = News::findOrFail($id);
        $news->delete();
    }
}
