<?php

$srcPath = 'C:/Users/ok/.gemini/antigravity/brain/be512e7d-aab1-42be-8db3-eb121f0bdefb/.user_uploaded/media_1788499815048.png';
$im = imagecreatefrompng($srcPath);
$w = imagesx($im);
$h = imagesy($im);

echo "Dimensions: {$w}x{$h}\n";

// Sample background pixel at top-left corner (0, 0)
$bgRgb = imagecolorat($im, 0, 0);
$bgR = ($bgRgb >> 16) & 0xFF;
$bgG = ($bgRgb >> 8) & 0xFF;
$bgB = $bgRgb & 0xFF;
echo "Top Left BG pixel RGB: ($bgR, $bgG, $bgB)\n";

// Sample background pixel at (50, 50)
$bgRgb2 = imagecolorat($im, 50, 50);
$bgR2 = ($bgRgb2 >> 16) & 0xFF;
$bgG2 = ($bgRgb2 >> 8) & 0xFF;
$bgB2 = $bgRgb2 & 0xFF;
echo "Pixel (50,50) RGB: ($bgR2, $bgG2, $bgB2)\n";

// Sample logo emblem pixel inside the gold N (e.g. middle left)
$emblemRgb = imagecolorat($im, 200, (int) ($h / 2));
$emR = ($emblemRgb >> 16) & 0xFF;
$emG = ($emblemRgb >> 8) & 0xFF;
$emB = $emblemRgb & 0xFF;
echo 'Sample Emblem RGB at (200, '.(int) ($h / 2)."): ($emR, $emG, $emB)\n";
