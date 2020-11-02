<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Trait UploadAble
 * @package App\Traits
 */
trait UploadAble
{
    /**
     * @param UploadedFile $file
     * @param null $folder
     * @param string $disk
     * @param null $filename
     * @return false|string
     */
    public function uploadOne(UploadedFile $file, $folder = null, $disk = 'public',  $filename = null)
    {
        if (is_null($disk))
            $disk = 'public';

        $name = !is_null($filename) ? $filename : str_random(25);

        $name_with_extension = $name . "." . $file->getClientOriginalExtension();

        return $file->storeAs(
            $folder,
            $name_with_extension,
            $disk
        );
    }

    /**
     * @param null $path
     * @param string $disk
     * @param bool $mobile
     */
    public function deleteOne($path = null, $disk = 'public' , $mobile = false)
    {
        if (is_null($disk))
            $disk = 'public';

        Storage::disk($disk)->delete($path);

        if ($mobile)
            Storage::disk($disk)->delete('mobile/'.$path);

    }


}
