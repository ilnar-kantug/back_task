<?php
declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PhotoService
{
    const PRODUCT_IMAGES_FOLDER = 'product_images/';

    public function savePhoto(Request $request)
    {
        $subfolder = $this->generateSubfolder();

        $filename = $this->generateName();

        $isSaved = $request->file('photo')->storeAs(
            self::PRODUCT_IMAGES_FOLDER.$subfolder,
            $filename,
            'public'
        );

        if ($isSaved) {
            return $subfolder.$filename;
        }

        throw new HttpException(Response::HTTP_BAD_REQUEST, 'Cant handle the request, try later');
    }

    protected function generateSubfolder(): string
    {
        return date('y').'/'.date('W').'/';
    }

    protected function generateName(): string
    {
        return Str::random(20).'.jpg';
    }
}
