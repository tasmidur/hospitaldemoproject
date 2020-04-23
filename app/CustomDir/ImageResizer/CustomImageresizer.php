<?php
namespace App\CustomDir\ImageResizer;
use Image;

class CustomImageresizer{

    public function ImageResizer($iamgefile,$imagedir){
     
            //get filename with extension
            $filenamewithextension = $iamgefile->getClientOriginalName();
     
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
     
            //get file extension
            $extension = $iamgefile->getClientOriginalExtension();
     
            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;
     
            //Upload File
            $iamgefile->storeAs('public/profile_images', $filenametostore);
            $iamgefile->storeAs('public/profile_images/thumbnail', $filenametostore);
     
            //Resize image here
            $thumbnailpath = public_path('storage/profile_images/thumbnail/'.$filenametostore);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);
     
            return $filenametostore."/".$thumbnailpath;
             
    }
}
