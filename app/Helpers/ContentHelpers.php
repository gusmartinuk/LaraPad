<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ContentHelper {
    public static function handleImages($content)
    {
        $pattern = '/<img[^>]+src="data:image\/[^;]+;base64,([^"]+)"[^>]*>/i';
        return preg_replace_callback($pattern, function ($matches) {
            $imageData = base64_decode($matches[1]);
            if (!$imageData) {
                return ''; // Geçersiz resim verisini yok say
            }
            $filename = 'notes_images/' . uniqid() . '.png';
            Storage::put('public/' . $filename, $imageData);
            return '<img src="/storage/' . $filename . '">';
        }, $content);
    }
}



