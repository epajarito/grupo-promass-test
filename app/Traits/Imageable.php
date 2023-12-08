<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait Imageable
{

    /**
     * Method to save image
     *
     * @param UploadedFile $uploadedFile
     * @param null $folder
     * @param null $filename
     * @param string $disk
     *
     * @return string
     */
    public function upload(UploadedFile $uploadedFile, $folder = null, $filename = null, string $disk = "public"): string
    {
        $filename = $filename ?? Str::random(24);
        $extension = $uploadedFile->getClientOriginalExtension();

        return "storage/" . $uploadedFile->storeAs($folder, $filename . "." . $extension, $disk);
    }

    /**
     * Method to remove image
     *
     * @param string|null $fileName
     * @param string $disk
     *
     * @return void
     */
    public function remove(string|null $fileName, string $disk = "public"): void
    {
        if (!is_null($fileName) && Storage::disk($disk)->exists($fileName)) {
            Storage::disk($disk)->delete($fileName);
        }
    }
}
