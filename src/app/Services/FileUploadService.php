<?php

namespace App\Services;

use App\Http\Requests\ArticleRequest;
use App\Http\Requests\RegisterRequest;

use App\Models\PostImage;
use App\Models\Thumbnail;
use Illuminate\Support\Facades\DB;

class FileUploadService
{
    /**
     * @throws \Exception
     */

    const string USER_ICON_DIR = 'public/userIcon';
    const string THUMB_DIR = 'public/thumbnails';
    const string POST_IMAGE_DIR = 'public/postImages';

    private function fileSizeChecker(int $fileSize): void
    {
        // filesizeがbyte: 15000000byte == 15MB
        if ($fileSize > 15000000) {
            throw new \Exception('ファイルサイズが大きすぎます');
        }
    }

    private function fileFormatChecker(string $fileExtension): void
    {
        if ($fileExtension !== 'jpeg' && $fileExtension !== 'png' && $fileExtension !== 'jpg') {
            throw new \Exception('ファイル形式が不正です');
        }
    }

    public static function userIconUploader(RegisterRequest $request): string
    {
        $fileExtension = $request->userIcon->getClientOriginalExtension();
        $fileSize = $request->userIcon->getSize();

        (new FileUploadService)->fileFormatChecker($fileExtension);
        (new FileUploadService)->fileSizeChecker($fileSize);

        $file = $request->userIcon->store(self::USER_ICON_DIR);

        return pathinfo($file, PATHINFO_BASENAME);
    }

    /**
     * @throws \Exception
     */
    public static function articleImageUploader(ArticleRequest $request): array
    {
        $fileExtension = $request->thumbnail->getClientOriginalExtension();
        $fileSize = $request->thumbnail->getSize();

        (new FileUploadService)->fileFormatChecker($fileExtension);
        (new FileUploadService)->fileSizeChecker($fileSize);

        $uploadedImages = [];

        $thumbFile = $request->thumbnail->store(self::THUMB_DIR);
        $thumbFilename = pathinfo($thumbFile, PATHINFO_BASENAME);

        $uploadedImages['thumb'] = $thumbFilename;

        for ($files = 0; $files < count($request->postImage); $files++) {
            $fileExtension = $request->postImage[$files]->getClientOriginalExtension();
            $fileSize = $request->postImage[$files]->getSize();

            (new FileUploadService)->fileFormatChecker($fileExtension);
            (new FileUploadService)->fileSizeChecker($fileSize);

            $postImageFile = $request->postImage[$files]->store(self::POST_IMAGE_DIR);
            $postImageFilename = pathinfo($postImageFile, PATHINFO_BASENAME);

            $uploadedImages['postImages'][] = $postImageFilename;
        }

        return $uploadedImages;
    }
}
