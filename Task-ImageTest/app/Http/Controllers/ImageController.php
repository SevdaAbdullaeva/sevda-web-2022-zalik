<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function imageStore(Request $request)
    {
        $file = $request->file('file');

        if ($file == '')
            return response(NULL, Response::HTTP_UNPROCESSABLE_ENTITY);

        $pictureExtArray = array( 'gif', 'jpg', 'jpeg', 'png');
        if (!in_array($file->getClientOriginalExtension(), $pictureExtArray))
            return response(NULL, Response::HTTP_UNPROCESSABLE_ENTITY);

        $record = Image::create(['filename' => $file->getClientOriginalName()]);
        Storage::disk('local')->put($record->filename, $file);

        return response()->json(['data' => $record], Response::HTTP_CREATED);
    }
}
