<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function storeCompressedImage(UploadedFile $file, string $directory = 'products', int $targetKb = 100): string
    {
        if (! $file->isValid()) {
            return $this->storeRawFile($file, $directory);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $filename = uniqid('img_', true) . '.' . $extension;
        $storagePath = trim($directory, '/') . '/' . $filename;

        $imagePath = $file->getRealPath() ?: $file->getPathname();
        if (! $imagePath || ! is_file($imagePath)) {
            return $this->storeRawFile($file, $directory);
        }

        $image = $this->createImageResource($imagePath);
        if (! $image) {
            return $this->storeRawFile($file, $directory);
        }

        $image = $this->resizeImageResource($image, 1200, 1200);
        [$contents, $savedExtension] = $this->compressImageResource($image, $extension, $targetKb);
        imagedestroy($image);

        if ($savedExtension !== $extension) {
            $storagePath = trim($directory, '/') . '/' . uniqid('img_', true) . '.' . $savedExtension;
        }

        Storage::disk('public')->put($storagePath, $contents);
        return $storagePath;
    }

    protected function storeRawFile(UploadedFile $file, string $directory = 'products'): string
    {
        return $file->store($directory, 'public');
    }

    protected function createImageResource(string $path)
    {
        $imageInfo = getimagesize($path);
        if (! $imageInfo) {
            return null;
        }

        switch ($imageInfo[2]) {
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($path);
            case IMAGETYPE_PNG:
                return imagecreatefrompng($path);
            case IMAGETYPE_GIF:
                return imagecreatefromgif($path);
            default:
                return null;
        }
    }

    protected function resizeImageResource($image, int $maxWidth, int $maxHeight)
    {
        $width = imagesx($image);
        $height = imagesy($image);

        if ($width <= $maxWidth && $height <= $maxHeight) {
            return $image;
        }

        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = (int) round($width * $ratio);
        $newHeight = (int) round($height * $ratio);

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($image);

        return $resized;
    }

    protected function compressImageResource($image, string $extension, int $targetKb): array
    {
        $extension = strtolower($extension);
        if ($extension === 'png') {
            $contents = $this->compressPng($image, $targetKb);
            if (strlen($contents) / 1024 <= $targetKb) {
                return [$contents, 'png'];
            }

            $contents = $this->compressJpeg($image, $targetKb);
            return [$contents, 'jpg'];
        }

        return [$this->compressJpeg($image, $targetKb), $extension];
    }

    protected function compressJpeg($image, int $targetKb): string
    {
        $quality = 90;
        $contents = '';
        $sizeKb = PHP_INT_MAX;

        while ($quality >= 20) {
            ob_start();
            imagejpeg($image, null, $quality);
            $contents = ob_get_clean();
            $sizeKb = strlen($contents) / 1024;

            if ($sizeKb <= $targetKb) {
                return $contents;
            }

            $quality -= 10;
        }

        while ($sizeKb > $targetKb && imagesx($image) > 300) {
            $image = $this->resizeImageResource($image, (int) (imagesx($image) * 0.85), (int) (imagesy($image) * 0.85));
            ob_start();
            imagejpeg($image, null, 20);
            $contents = ob_get_clean();
            $sizeKb = strlen($contents) / 1024;
        }

        return $contents;
    }

    protected function compressPng($image, int $targetKb): string
    {
        $compression = 6;
        $contents = '';
        $sizeKb = PHP_INT_MAX;

        while ($compression <= 9) {
            ob_start();
            imagesavealpha($image, true);
            imagepng($image, null, $compression);
            $contents = ob_get_clean();
            $sizeKb = strlen($contents) / 1024;

            if ($sizeKb <= $targetKb) {
                return $contents;
            }

            $compression++;
        }

        return $contents;
    }
}
