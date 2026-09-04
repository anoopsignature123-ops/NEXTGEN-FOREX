<?php

$srcPath = 'C:/Users/ok/.gemini/antigravity/brain/be512e7d-aab1-42be-8db3-eb121f0bdefb/.user_uploaded/media_1788499815048.png';
$im = @imagecreatefrompng($srcPath);

if (! $im) {
    $im = @imagecreatefromjpeg($srcPath);
}

if (! $im) {
    exit("Failed to load source image\n");
}

$width = imagesx($im);
$height = imagesy($im);

// Crop tight bounds first (remove unnecessary outer black margins)
$minX = $width;
$maxX = 0;
$minY = $height;
$maxY = 0;

for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        $rgb = imagecolorat($im, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $brightness = ($r * 0.299 + $g * 0.587 + $b * 0.114);

        if ($brightness > 22) {
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

$cropW = max(1, $maxX - $minX + 1);
$cropH = max(1, $maxY - $minY + 1);

// Create transparent cropped image
$transparentIm = imagecreatetruecolor($cropW, $cropH);
imagealphablending($transparentIm, false);
imagesavealpha($transparentIm, true);

$transparentColor = imagecolorallocatealpha($transparentIm, 0, 0, 0, 127);
imagefill($transparentIm, 0, 0, $transparentColor);

for ($x = 0; $x < $cropW; $x++) {
    for ($y = 0; $y < $cropH; $y++) {
        $origX = $minX + $x;
        $origY = $minY + $y;
        $rgb = imagecolorat($im, $origX, $origY);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        $brightness = ($r * 0.299 + $g * 0.587 + $b * 0.114);

        if ($brightness < 20) {
            $color = imagecolorallocatealpha($transparentIm, 0, 0, 0, 127);
        } elseif ($brightness < 45) {
            $alpha = (int) ((45 - $brightness) / 25 * 127);
            $color = imagecolorallocatealpha($transparentIm, $r, $g, $b, min(127, max(0, $alpha)));
        } else {
            $color = imagecolorallocatealpha($transparentIm, $r, $g, $b, 0);
        }
        imagesetpixel($transparentIm, $x, $y, $color);
    }
}

// Save transparent full logo
imagepng($transparentIm, 'c:/xampp/htdocs/nextgen-forex/public/images/nextgen_logo.png');
echo "Transparent logo created! Cropped size: {$cropW}x{$cropH}\n";

// Create favicon from left 'N' emblem
$emblemW = (int) ($cropW * 0.38);
$emblemH = $cropH;

$favSize = max($emblemW, $emblemH);
$favIm = imagecreatetruecolor($favSize, $favSize);
imagealphablending($favIm, false);
imagesavealpha($favIm, true);
imagefill($favIm, 0, 0, $transparentColor);

$offsetX = (int) (($favSize - $emblemW) / 2);
$offsetY = (int) (($favSize - $emblemH) / 2);

imagecopy($favIm, $transparentIm, $offsetX, $offsetY, 0, 0, $emblemW, $emblemH);

imagepng($favIm, 'c:/xampp/htdocs/nextgen-forex/public/assets/images/favicon.png');
imagepng($favIm, 'c:/xampp/htdocs/nextgen-forex/public/favicon.ico');
imagepng($favIm, 'c:/xampp/htdocs/nextgen-forex/public/favicon.png');

echo "Transparent Favicon created! Size: {$favSize}x{$favSize}\n";
