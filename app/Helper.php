<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class helper
{
    public function moveFile($request,$path)
    {
        $image = $request->image;
        $imageName = Carbon::now()->format('Y-m-d-H-i-s').'-'.random_int(1000,99999).'.'.$image->getClientOriginalExtension();
        $image->move(public_path($path), $imageName);
        return $path.'/'.$imageName;
    }
    public function updateFile($model,$request,$path)
    {
        if($request->image == null)
        {
            return $model->profile_photo_path;
        }else{
            File::delete($model->profile_photo_path);
            $image = $request->image;
            $imageName = Carbon::now()->format('Y-m-d-H-i-s').'-'.random_int(1000,99999).'.'.$image->getClientOriginalExtension();
            $image->move(public_path($path), $imageName);
            return $path.'/'.$imageName;
        }
    }
}
