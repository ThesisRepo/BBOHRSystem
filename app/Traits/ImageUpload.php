<?php
namespace App\Traits;

trait ImageUpload
{

  public function image_upload_from_trait($img) {
    $imageName = time().'.'.$img->getClientOriginalExtension();
    $img->move(public_path('images'),$imageName);
    return 'images/'.$imageName;
  }

}