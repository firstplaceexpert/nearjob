<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KtpWatermarkService
{
    /**
     * Process uploaded KTP image, stamp permanent "NEAR JOB" security watermark,
     * and save to public storage disk.
     *
     * @param UploadedFile|string $file
     * @param string|null $identifier Optional identifier (e.g. user ID or name)
     * @return string Relative storage path (e.g. 'ktp/watermarked_ktp_xyz.jpg')
     */
    public static function processAndSave($file, ?string $identifier = null): string
    {
        $filePath = is_string($file) ? $file : $file->getRealPath();

        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("File gambar KTP tidak ditemukan: {$filePath}");
        }

        $imageInfo = @getimagesize($filePath);
        if (!$imageInfo) {
            throw new \InvalidArgumentException("Berkas bukan format gambar yang valid.");
        }

        $mime = $imageInfo['mime'];
        $srcImage = match ($mime) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($filePath),
            'image/png'               => @imagecreatefrompng($filePath),
            'image/webp'              => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($filePath) : null,
            'image/gif'               => @imagecreatefromgif($filePath),
            default                   => null,
        };

        if (!$srcImage) {
            throw new \RuntimeException("Gagal memuat gambar KTP untuk pemrosesan watermark.");
        }

        $width = imagesx($srcImage);
        $height = imagesy($srcImage);

        // Fix image orientation if EXIF orientation tag exists
        if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
            if (function_exists('exif_read_data')) {
                $exif = @exif_read_data($filePath);
                if (!empty($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $srcImage = imagerotate($srcImage, 180, 0);
                            break;
                        case 6:
                            $srcImage = imagerotate($srcImage, -90, 0);
                            $tmp = $width; $width = $height; $height = $tmp;
                            break;
                        case 8:
                            $srcImage = imagerotate($srcImage, 90, 0);
                            $tmp = $width; $width = $height; $height = $tmp;
                            break;
                    }
                }
            }
        }

        // Create truecolor canvas with alpha support
        $canvas = imagecreatetruecolor($width, $height);
        imagealphablending($canvas, true);
        imagesavealpha($canvas, true);

        // Copy source to canvas
        imagecopy($canvas, $srcImage, 0, 0, 0, 0, $width, $height);
        imagedestroy($srcImage);

        // Colors for watermark
        $dateStr = date('d/m/Y');
        $watermarkText = "NEAR JOB • DOKUMEN IDENTITAS RESMI • " . $dateStr;
        $subText = "TIDAK BERLAKU UNTUK PINJAMAN / PIHAK KETIGA";

        // 1. Diagonal repeated watermarks across the image
        // Alpha: 0 (opaque) to 127 (transparent). 85 is nicely visible yet semi-transparent
        $textColorLight = imagecolorallocatealpha($canvas, 255, 255, 255, 75);
        $shadowColorDark = imagecolorallocatealpha($canvas, 0, 27, 58, 85); // Navy shadow

        // Use built-in GD font (Font 5 is the largest built-in font: ~9x15px)
        $font = 5;
        $stepY = max(80, (int)($height / 6));
        $stepX = max(180, (int)($width / 3));

        for ($y = 40; $y < $height; $y += $stepY) {
            for ($x = -100; $x < $width + 100; $x += $stepX) {
                // Shadow
                imagestring($canvas, $font, $x + 1, $y + 1, "NEAR JOB VERIFIKASI", $shadowColorDark);
                // Front text
                imagestring($canvas, $font, $x, $y, "NEAR JOB VERIFIKASI", $textColorLight);
            }
        }

        // 2. Large Official Watermark Badge across the bottom/center
        $badgeHeight = max(56, (int)($height * 0.16));
        $badgeY = $height - $badgeHeight - 20;

        // Semi-transparent dark navy banner
        $badgeBg = imagecolorallocatealpha($canvas, 0, 27, 58, 45); // #001b3a with ~65% opacity
        imagefilledrectangle($canvas, 15, $badgeY, $width - 15, $badgeY + $badgeHeight, $badgeBg);

        // Accent line on top of badge (Pink #e60067)
        $accentColor = imagecolorallocatealpha($canvas, 230, 0, 103, 20);
        imagefilledrectangle($canvas, 15, $badgeY, $width - 15, $badgeY + 4, $accentColor);

        // Text in badge (Use standard ASCII characters for clean rendering in GD font)
        $badgeTextMain = "[ NEAR JOB - KHUSUS VERIFIKASI IDENTITAS RESMI ]";
        $badgeTextSub  = "DOKUMEN INI DIAMANKAN OLEH NEAR JOB | " . $dateStr . " | TIDAK DAPAT DISEBARLUASKAN";

        $fontMain = 5;
        $textLen1 = strlen($badgeTextMain) * 9;
        $posX1 = max(25, (int)(($width - $textLen1) / 2));
        $posY1 = $badgeY + (int)($badgeHeight * 0.22);

        $textLen2 = strlen($badgeTextSub) * 9;
        $posX2 = max(25, (int)(($width - $textLen2) / 2));
        $posY2 = $posY1 + 22;

        $whiteSolid = imagecolorallocate($canvas, 255, 255, 255);
        $yellowNotice = imagecolorallocate($canvas, 254, 240, 138);

        imagestring($canvas, $fontMain, $posX1, $posY1, $badgeTextMain, $whiteSolid);
        imagestring($canvas, 4, $posX2, $posY2, $badgeTextSub, $yellowNotice);

        // Ensure target directory exists in public storage
        Storage::disk('public')->makeDirectory('ktp');

        $safeId = $identifier ? Str::slug($identifier) : 'user';
        $fileName = 'ktp/watermarked_ktp_' . $safeId . '_' . Str::random(12) . '.jpg';
        $destinationPath = Storage::disk('public')->path($fileName);

        // Save as high-quality JPEG
        imagejpeg($canvas, $destinationPath, 88);
        imagedestroy($canvas);

        return $fileName;
    }
}
