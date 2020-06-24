<?php

namespace App\Utils;

use Aws\Rekognition\RekognitionClient;
use Illuminate\Support\Facades\Storage;

class ResumeParser
{
    public static function extractPhoto($resumeFilePath, $photoFilePath)
    {
        $imageData = null;

        //File::mimeType($resumeFilePath) does not work on s3
        if (substr($resumeFilePath, -4) === '.pdf' && Storage::disk('s3')->exists($resumeFilePath)) {
            $imageData = self::pdfToImage($resumeFilePath);
        }

        if ($imageData) {
            $photo = self::rekognizePhoto($imageData);

            if ($photo) {
                Storage::disk('s3-avatars')->put($photoFilePath, $photo->getImageBlob());
                return true;
            }
        }

        return false;
    }

    protected static function pdfToImage($resumeFilePath)
    {
        $pdfFile = Storage::disk('s3')->get($resumeFilePath);
        return PdfToImage::fromContent($pdfFile)->getImageData();
    }

    protected static function rekognizePhoto($imageData): ?\Imagick
    {
        $options = [
            'region' => 'eu-central-1',
            'version' => 'latest'
        ];

        $rekognition = new RekognitionClient($options);
        $result = $rekognition->detectLabels(array(
                'Image' => array(
                    'Bytes' => $imageData,
                ),
            )
        );

        if ($result) {
            foreach ($result['Labels'] as $label) {
                if ($label['Name'] == 'Person' && !empty($label['Instances'] && !empty($label['Instances'][0]['BoundingBox']))) {
                    return self::cropImage(
                        $imageData,
                        $label['Instances'][0]['BoundingBox']['Width'],
                        $label['Instances'][0]['BoundingBox']['Height'],
                        $label['Instances'][0]['BoundingBox']['Left'],
                        $label['Instances'][0]['BoundingBox']['Top']);
                }
            }
        }

        return null;
    }

    protected static function cropImage($imageData, $width, $height, $left, $top)
    {
        $image = new \Imagick();
        $image->readImageBlob($imageData);
        $geometry = $image->getImageGeometry();

        $cropX = $left * $geometry['width'];
        $cropY = $top * $geometry['height'];
        $cropWidth = $width * $geometry['width'];
        $cropHeight = $height * $geometry['height'];

        $image->cropImage($cropWidth, $cropHeight, $cropX, $cropY);
        return $image;
    }
}
