<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Resources\PhotoResource;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Photo::all();
        return PhotoResource::collection(Photo::all());
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

        $validator = Validator::make($request->all(), [
            'photo' => 'required',
        ]);

        $photos = [];

        $photosLength = count($request->photo);

        for ($i = 0; $i < $photosLength; $i++) {
            $base64_str = $request->photo[$i];

            $image = base64_decode($base64_str);
            $name = time() . "_" . md5(uniqid(rand(), true)) . '.jpg';
            $path = '../storage/app/public/pictures/' . $name;

           // $path = str_replace("public", "storage\app\public", $path);

            $fp = fopen($path, 'w');
            if (fwrite($fp, $image)) {

                //geting original size
                //list($width, $height) = getimagesize($path);

                // open the image file
                $img = Image::make($path);
                // now you are able to resize the instance
                $img->resize(400, 400);
                // finally we save the image as a new file
                $img->save($path);

                $newPhoto = Photo::create([
                    'file_name' => $name,
                ]);

                array_push($photos, new PhotoResource($newPhoto));
            }
            fclose($fp);
        }
        return response()->json([
            'status' => 'success', 'data' => $photos,
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $photo_search = DB::table('photos')->select(['*'])->where('id', $id)->first();
        return new PhotoResource($photo_search);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //
    }
}
