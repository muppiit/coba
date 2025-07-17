<?php

namespace App\Helpers;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Color\Color;

class QrCodeHelper
{
    /**
     * Generate QR Code PNG base64 string.
     *
     * @param string $data
     * @param array $options
     * @return string Base64 encoded PNG
     */
    public static function generate(string $data, array $options = [])
    {
        // Default options
        $size = $options['size'] ?? 100;
        $margin = $options['margin'] ?? 2;
        $foreground = $options['foreground'] ?? [0, 0, 0]; 
        $background = $options['background'] ?? [255, 255, 255]; 
        $logoPath = $options['logoPath'] ?? null;
        $logoWidth = $options['logoWidth'] ?? 40;

        // Build QR Code
        $builder = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size($size)
            ->margin($margin)
            ->foregroundColor(new Color(...$foreground))
            ->backgroundColor(new Color(...$background));

        if ($logoPath) {
            $builder->logoPath($logoPath)
                    ->logoResizeToWidth($logoWidth);
        }

        $result = $builder->build();

        return base64_encode($result->getString());
    }
}
