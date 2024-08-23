<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\File;

class AttachmentService
{
    /**
     * Save attachment
     *
     * @param array $data
     * @return Attachment|null
     */
    public static function save($file, $collection, $path, $query)
    {
        try {
            $uniqueFileName = self::uniqueFileName();
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $fileType = $file->getMimeType();
            Storage::putFileAs($path, $file, $uniqueFileName . '.' . $file->getClientOriginalExtension());
            $filePath = $path . '/' . $uniqueFileName . '.' . $file->getClientOriginalExtension();

            $attachment = DB::transaction(function () use ($query, $fileName, $filePath, $fileSize, $fileType, $collection, $uniqueFileName) {
                $attachment = $query->attachments()->create([
                    'original_name' => $fileName,
                    'file_name' => $uniqueFileName,
                    'file_path' => $filePath,
                    'file_size' => $fileSize,
                    'file_type' => $fileType,
                    'collection' => $collection,
                ]);

                return $attachment;
            });

            return $attachment;
        } catch (\Exception $e) {
            Log::error('Error saving attachment: ' . $e);
            return null;
        }
    }

    /**
     * Unique file name
     *
     * @return string
     */
    public static function uniqueFileName()
    {
        return md5(uniqid() . time());
    }

    /**
     * Delete attachment
     *
     * @param Attachment $attachment
     * @return bool
     */
    public static function delete($attachment)
    {
        try {
            if ($attachment && Storage::exists($attachment->file_path)) {
                Storage::delete($attachment->file_path);
                $attachment->delete();
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Error deleting attachment: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete file
     *
     * @param Attachment $attachment
     * @return bool
     */
    public static function deleteFile($attachment)
    {
        try {
            if ($attachment && Storage::exists($attachment->file_path)) {
                Storage::delete($attachment->file_path);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Error deleting file: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update attachment
     *
     * @param $file
     * @param Attachment $attachment
     * @param $path
     * @return Attachment|null
     */
    public static function update($file, $attachment, $path)
    {
        try {
            // Delete old file
            self::deleteFile($attachment);

            $uniqueFileName = self::uniqueFileName();
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $fileType = $file->getMimeType();
            $filePath = $file->storeAs($path, $uniqueFileName . '.' . $file->getClientOriginalExtension());

            $attachment = DB::transaction(function () use ($attachment, $fileName, $filePath, $fileSize, $fileType, $uniqueFileName) {
                $attachment->update([
                    'original_name' => $fileName,
                    'file_name' => $uniqueFileName,
                    'file_path' => $filePath,
                    'file_size' => $fileSize,
                    'file_type' => $fileType,
                ]);

                return $attachment;
            });

            return $attachment;
        } catch (\Exception $e) {
            Log::error('Error updating attachment: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Store default image
     *
     * @param $collection
     * @param $path
     * @param $query
     */
    public static function storeDefaultImage($collection, $path, $query)
    {
        $defaultImagePath = self::getDefaultImagePath($collection);
        if (File::exists($defaultImagePath)) {
            $exists = Storage::exists($path . '/default.png');
            if (!$exists) {
                $fileContent = file_get_contents($defaultImagePath);
                Storage::put($path . '/default.png', $fileContent);
            }

            $attachment = $query->attachments()->create([
                'original_name' => 'default.png',
                'file_name' => 'default',
                'file_path' => $path . '/default.png',
                'file_size' => 0,
                'file_type' => 'image/png',
                'collection' => $collection,
            ]);
        }
    }

    /**
     * Get default image
     *
     * @return string
     */
    public static function getDefaultImagePath($collection)
    {
        // currently we have only one default image for all collections
        return  public_path('images/media/default.png');
    }
}