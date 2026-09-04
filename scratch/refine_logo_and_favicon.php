<?php

$srcPath = 'C:/Users/ok/.gemini/antigravity/brain/be512e7d-aab1-42be-8db3-eb121f0bdefb/.user_uploaded/media_1788499815048.png';
$im = imagecreatefrompng($srcPath);
if (! $im) {
    $im = imagecreatefromjpeg($srcPath);
}

$w = imagesx($im);
$h = imagesy($im);

// ==========================================
// 1. HIGH-RES CLEAN 3D EMBLEM FAVICON (512x512)
// ==========================================
$emblemMinX = $w;
$emblemMaxX = 0;
$emblemMinY = $h;
$emblemMaxY = 0;

for ($y = 0; $y < $h; $y++) {
    for ($x = 0; $x < (int) ($w * 0.42); $x++) {
        $rgb = imagecolorat($im, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $brightness = ($r * 0.299 + $g * 0.587 + $b * 0.114);

        if ($brightness > 38 || ($r > 60 && $g > 40) || ($g > 50 && $r > 40)) {
            if ($x < $emblemMinX) {
                $emblemMinX = $x;
            }
            if ($x > $emblemMaxX) {
                $emblemMaxX = $x;
            }
            if ($y < $emblemMinY) {
                $emblemMinY = $y;
            }
            if ($y > $emblemMaxY) {
                $emblemMaxY = $y;
            }
        }
    }
}

$embW = max(1, $emblemMaxX - $emblemMinX + 1);
$embH = max(1, $emblemMaxY - $emblemMinY + 1);

// Extract raw emblem to temp image with clean transparency
$embIm = imagecreatetruecolor($embW, $embH);
imagealphablending($embIm, false);
imagesavealpha($embIm, true);
$trans = imagecolorallocatealpha($embIm, 0, 0, 0, 127);
imagefill($embIm, 0, 0, $trans);

for ($y = 0; $y < $embH; $y++) {
    for ($x = 0; $x < $embW; $x++) {
        $origX = $emblemMinX + $x;
        $origY = $emblemMinY + $y;
        $rgb = imagecolorat($im, $origX, $origY);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $brightness = ($r * 0.299 + $g * 0.587 + $b * 0.114);

        if ($brightness < 28 && ! ($r > 50 && $g > 35)) {
            $color = imagecolorallocatealpha($embIm, 0, 0, 0, 127);
        } else {
            $alpha = 0;
            if ($brightness < 45) {
                $alpha = (int) ((45 - $brightness) / 17 * 127);
                $alpha = min(127, max(0, $alpha));
            }

            // Slight vibrancy enhancement for gold/green emblem on favicon
            $rBoost = min(255, (int) ($r * 1.15));
            $gBoost = min(255, (int) ($g * 1.15));
            $bBoost = min(255, (int) ($b * 1.05));

            $color = imagecolorallocatealpha($embIm, $rBoost, $gBoost, $bBoost, $alpha);
        }
        imagesetpixel($embIm, $x, $y, $color);
    }
}

// 512x512 Favicon canvas
$favDim = 512;
$favIm = imagecreatetruecolor($favDim, $favDim);
imagealphablending($favIm, false);
imagesavealpha($favIm, true);
imagefill($favIm, 0, 0, $trans);

// Scale emblem to 92% of square canvas for maximum clarity
$targetSize = (int) ($favDim * 0.92);
$padX = (int) (($favDim - $targetSize) / 2);
$padY = (int) (($favDim - $targetSize) / 2);

imagecopyresampled($favIm, $embIm, $padX, $padY, 0, 0, $targetSize, $targetSize, $embW, $embH);

// Save favicons
imagepng($favIm, 'c:/xampp/htdocs/nextgen-forex/public/assets/images/favicon.png');
imagepng($favIm, 'c:/xampp/htdocs/nextgen-forex/public/favicon.ico');
imagepng($favIm, 'c:/xampp/htdocs/nextgen-forex/public/favicon.png');
echo "High-resolution transparent 3D Favicon generated!\n";

// ==========================================
// 2. FULL BRAND LOGO (HIGH CONTRAST & TRANSPARENT)
// ==========================================
$fullMinX = $w;
$fullMaxX = 0;
$fullMinY = $h;
$fullMaxY = 0;

for ($y = 0; $y < $h; $y++) {
    for ($x = 0; $x < $w; $x++) {
        $rgb = imagecolorat($im, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $brightness = ($r * 0.299 + $g * 0.587 + $b * 0.114);

        if ($brightness > 38 || ($r > 55 && $g > 40) || ($g > 50 && $r > 35)) {
            if ($x < $fullMinX) {
                $fullMinX = $x;
            }
            if ($x > $fullMaxX) {
                $fullMaxX = $x;
            }
            if ($y < $fullMinY) {
                $fullMinY = $y;
            }
            if ($y > $fullMaxY) {
                $fullMaxY = $y;
            }
        }
    }
}

$logoW = max(1, $fullMaxX - $fullMinX + 1);
$logoH = max(1, $fullMaxY - $fullMinY + 1);

$logoIm = imagecreatetruecolor($logoW, $logoH);
imagealphablending($logoIm, false);
imagesavealpha($logoIm, true);
$transLogo = imagecolorallocatealpha($logoIm, 0, 0, 0, 127);
imagefill($logoIm, 0, 0, $transLogo);

for ($y = 0; $y < $logoH; $y++) {
    for ($x = 0; $x < $logoW; $x++) {
        $origX = $fullMinX + $x;
        $origY = $fullMinY + $y;
        $rgb = imagecolorat($im, $origX, $origY);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        $brightness = ($r * 0.299 + $g * 0.587 + $b * 0.114);

        // Strict background map dot removal
        if ($brightness < 32 && ! ($r > 55 && $g > 40)) {
            $color = imagecolorallocatealpha($logoIm, 0, 0, 0, 127);
        } else {
            $alpha = 0;
            if ($brightness < 50) {
                $alpha = (int) ((50 - $brightness) / 18 * 127);
                $alpha = min(127, max(0, $alpha));
            }

            // If it's the green part of "GEN", brighten it up so it stands out against dark green background
            $outR = $r;
            $outG = $g;
            $outB = $b;

            if ($g > $r && $g > $b) {
                // Boost green text brightness and add gold tint to highlight
                $outG = min(255, (int) ($g * 1.35));
                $outR = min(255, (int) ($r * 1.25 + 20));
            } elseif ($r > 100 && $g > 80) {
                // Boost gold metallic text brightness
                $outR = min(255, (int) ($r * 1.12));
                $outG = min(255, (int) ($g * 1.12));
            }

            $color = imagecolorallocatealpha($logoIm, $outR, $outG, $outB, $alpha);
        }
        imagesetpixel($logoIm, $x, $y, $color);
    }
}

imagepng($logoIm, 'c:/xampp/htdocs/nextgen-forex/public/images/nextgen_logo.png');
echo "Enhanced high-contrast transparent logo saved! Size: {$logoW}x{$logoH}\n";
