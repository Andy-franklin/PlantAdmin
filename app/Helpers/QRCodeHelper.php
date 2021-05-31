<?php


namespace App\Helpers;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class QRCodeHelper
{
    public static function generateQRCode(QRCode $code): string
    {
        return Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($code->getData())
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size($code->getSize())
            ->margin($code->getMargin())
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            //Todo: It might be nice to have a logo
            //->logoPath(__DIR__.'/assets/symfony.png')
            ->labelText($code->getLabel())
            ->labelFont(new NotoSans($code->getFontSize()))
            ->labelAlignment(new LabelAlignmentCenter())
            ->build()
            ->getDataUri();
    }
}
