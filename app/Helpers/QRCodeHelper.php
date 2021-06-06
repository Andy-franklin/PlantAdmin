<?php


namespace App\Helpers;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
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
        $colour = new Color(8, 92, 50);

        return Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($code->getData())
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size($code->getSize())
            ->margin($code->getMargin())
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->labelText($code->getLabel())
            ->labelFont(new NotoSans($code->getFontSize()))
            ->labelAlignment(new LabelAlignmentCenter())
            ->foregroundColor($colour)
            ->labelTextColor($colour)
            ->build()
            ->getDataUri();
    }
}
