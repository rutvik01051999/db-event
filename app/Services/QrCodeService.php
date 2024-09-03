<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class QrCodeService
{
    /**
     * Generate QR code
     *
     * @param Event $event
     * @return string
     */
    public static function generateAndSave(Event $event): string
    {
        $url = $event->event_url;
        $parseUrl = parse_url($url);
        $path = $parseUrl['path'] ?? '';
        $id = str_replace(['/', '.php'], ['', ''], $path);
        $payload = [
            'name' => $event->name,
            'organization' => 305254,
            'qr_type' => 2,
            'campaign' => [
                'content_type' => 1,
                'custom_url' => route('user.event.form', ['id' => $id]),
            ],
            'location_enabled' => false,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Token ' . config('qrcode.token'),
            'Content-Type' => 'application/json',
        ])->post(config('qrcode.generate_url'), $payload);

        if ($response->failed()) {
            Log::error('Failed to generate QR code: ' . $response->body());
        }

        $data = $response->json();
        $id = $data['id'];

        $downloadUrl = config('qrcode.download_url');
        $downloadUrl = Str::replace('{id}', $id, $downloadUrl);
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . config('qrcode.token'),
        ])->get($downloadUrl, [
            'size' => 1024,
            'error_correction_level' => 5,
            'canvas_type' => 'pdf',
        ]);

        if ($response->failed()) {
            Log::error('Failed to download QR code: ' . $response->body());
        }

        $data = $response->json();
        $qrCodeUrl = data_get($data, 'urls.pdf');
        $name = $data['name'] ?? 'qrcode';

        // Store to Storage
        $saveTo = 'qrcodes/' . $event->id;
        $fileName = $name . '.pdf';
        $fileContents = Http::get($qrCodeUrl)->body();

        Storage::put($saveTo . '/' . $fileName, $fileContents);

        $event->qr_code_id = $id;
        $event->qr_code_path = $saveTo . '/' . $fileName;
        $event->save();

        return $event->qr_code_path;
    }
}
