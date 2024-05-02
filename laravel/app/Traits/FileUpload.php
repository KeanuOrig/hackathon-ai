<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\File;
use Carbon\Carbon;

trait FileUpload {

    public function upload($file, $key_name, $folder_path) {
        /* ($request, $id, $key_name, $folder_path) */
        
        $disk = \Storage::disk('local'); 

        $folder = $folder_path;
        $title = $file->getClientOriginalName();
        $filename = (string) Str::uuid($title).date("Ymd").".".$file->getClientOriginalExtension();
        
        if (!file_exists($disk->path('/' . $folder))) {
            $disk->makeDirectory($folder);
        }

        $upload = $disk->putFileAs("/{$folder}", new File($file), $filename);
        $path = $disk->url("/{$folder}"."/$filename");

        if ($upload) {

            $path = base_path() . '/storage/app/' . $folder_path. '/'. $filename; // For local only

            $saved_file = [    
                'title'=> $title, 
                'url' => $path, 
                'filename' => $filename,
                'timestamp' =>  Carbon::now(),
            ];
            
            return $saved_file;

        } else {
            return null;
        }

    }
}