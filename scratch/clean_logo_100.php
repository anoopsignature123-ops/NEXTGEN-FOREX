<?php

$srcPath = 'C:/Users/ok/.gemini/antigravity/brain/be512e7d-aab1-42be-8db3-eb121f0bdefb/.user_uploaded/media_1788499815048.png';
$im = imagecreatefrompng($srcPath);
if (! $im) {
    $im = imagecreatefromjpeg($srcPath);
}

$w = imagesx($im);
$h = imagesy($im);

// 1. Find tight bounds of logo elements
$minX = $w;
$maxX = 0;
$minY = $h;
$maxY = 0;

for ($y = 0; $y < $h; $y++) {
    for ($x = 0; $x < $w; $x++) {
        $rgb = imagecolorat($im, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $brightness = ($r * 0.299 + $g * 0.587 + $b * 0.114);

        // Logo pixels have distinct gold or green color or high brightness
        $isLogoPixel = ($r > 75 && $g > 55) ||
                       ($g > 70 && $r > 40) ||
                       ($r > 110) ||
                       ($brightness > 70);

        if ($isLogoPixel) {
            if ($x < $minX) {
                $minX = $x;
            }
            if ($x > $maxX) {
                $maxX = $x;
            }
            if ($y < $minY) {
                $minY = $y;
            }
            if ($y > $maxY) {
                $maxY = $y;
            }
        }
    }
}

echo "Tight Logo Bounds: X($minX -> $maxX), Y($minY -> $maxY)\n";

$logoW = max(1, $maxX - $minX + 1);
$logoH = max(1, $maxY - $minY + 1);

$logoIm = imagecreatetruecolor($logoW, $logoH);
imagealphablending($logoIm, false);
imagesavealpha($logoIm, true);
$trans = imagecolorallocatealpha($logoIm, 0, 0, 0, 127);
imagefill($logoIm, 0, 0, $trans);

for ($y = 0; $y < $logoH; $y++) {
    for ($x = 0; $x < $logoW; $x++) {
        $origX = $minX + $x;
        $origY = $minY + $y;
        $rgb = imagecolorat($im, $origX, $origY);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $brightness = ($r * 0.299 + $g * 0.587 + $b * 0.114);

        // Strict 100% binary/smooth transparency rule
        // Eliminates ALL map dots, grid lines, and background textures completely!
        $isGold = ($r > 70 && $g > 50 && $r + $g > 130);
        $isGreenText = ($g > 65 && $g > $b * 1.2);
        $isBrightMetal = ($brightness > 60);

        if (! $isGold && ! $isGreenText && ! $isBrightMetal) {
            $color = imagecolorallocatealpha($logoIm, 0, 0, 0, 127);
        } else {
            // Smooth edge anti-aliasing ONLY for logo edge pixels
            $alpha = 0;
            if ($brightness < 55) {
                $alpha = (int) ((55 - $brightness) / 20 * 127);
                $alpha = min(127, max(0, $alpha));
            }

            // Color boost for maximum vibrancy on dark backgrounds
            $outR = $r;
            $outG = $g;
            $outB = $b;
            if ($g > $r && $g > $b) {
                // "GEN" metallic green text boost
                $outG = min(255, (int) ($g * 1.35));
                $outR = min(255, (int) ($r * 1.2 + 25));
            } elseif ($r > 90 && $g > 70) {
                // Gold metallic text boost
                $outR = min(255, (int) ($r * 1.15));
                $outG = min(255, (int) ($g * 1.15));
            }

            $color = imagecolorallocatealpha($logoIm, $outR, $outG, $outB, $alpha);
        }
        imagesetpixel($logoIm, $x, $y, $color);
    }
}

imagepng($logoIm, 'c:/xampp/htdocs/nextgen-forex/public/images/nextgen_logo.png');
echo "Clean transparent logo saved: {$logoW}x{$logoH}\n";
