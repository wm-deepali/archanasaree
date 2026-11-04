<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

trait StoresHomeImages
{
    /** Compress and store an uploaded image as WebP on the public disk. */
    protected function compressAndStore(UploadedFile $file, string $folder, int $maxWidth = 1600, int $quality = 80): string
    {
        $manager = ImageManager::usingDriver(Driver::class);
        $image = $manager->decode($file);

        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $encoded = $image->encodeUsingFormat(Format::WEBP, quality: $quality);

        $path = trim($folder, '/') . '/' . Str::uuid() . '.webp';
        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    protected function deleteStored(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}