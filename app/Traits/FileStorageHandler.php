<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait FileStorageHandler
 {
    public function storeFile( UploadedFile $file ):string {
        $fileName = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $name               = $fileName . '_' . time() . '.' . $ext;
        $destinationPath    = public_path() . '/posts';
        $file->move( $destinationPath, $name );
        $path = url( 'posts' ) . '/'. $name;
        return $path;
    }
}