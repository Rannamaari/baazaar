<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\ImageOptimizer\Optimizers\Gifsicle;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\ImageOptimizer\Optimizers\Optipng;
use Spatie\ImageOptimizer\Optimizers\Pngquant;
use Spatie\ImageOptimizer\Optimizers\Svgo;

class ImageOptimizationService
{
    protected OptimizerChain $optimizerChain;

    public function __construct()
    {
        $this->optimizerChain = (new OptimizerChain)
            ->addOptimizer(new Jpegoptim([
                '-m85', // Maximum quality
                '--strip-all', // Remove metadata
                '--all-progressive', // Progressive JPEG
            ]))
            ->addOptimizer(new Pngquant([
                '--quality=65-80', // Quality range
                '--force', // Overwrite existing files
            ]))
            ->addOptimizer(new Optipng([
                '-i0', // Interlace
                '-o2', // Optimization level
                '-quiet', // Quiet mode
            ]))
            ->addOptimizer(new Svgo([
                '--disable=cleanupIDs', // Keep IDs for better compatibility
            ]))
            ->addOptimizer(new Gifsicle([
                '-b', // Backup original
                '-O3', // Optimization level
            ]));
    }

    /**
     * Optimize an uploaded image file
     */
    public function optimizeUploadedFile(UploadedFile $file, string $disk = 'public'): string
    {
        // Store the file first
        $path = $file->store('temp', $disk);
        $fullPath = Storage::disk($disk)->path($path);

        // Optimize the image
        $this->optimizerChain->optimize($fullPath);

        // Move to final location
        $finalPath = $this->generateOptimizedPath($file, $disk);
        Storage::disk($disk)->move($path, $finalPath);

        return $finalPath;
    }

    /**
     * Optimize an existing image file
     */
    public function optimizeExistingFile(string $path, string $disk = 'public'): void
    {
        $fullPath = Storage::disk($disk)->path($path);

        if (file_exists($fullPath)) {
            $this->optimizerChain->optimize($fullPath);
        }
    }

    /**
     * Generate optimized file path
     */
    protected function generateOptimizedPath(UploadedFile $file, string $disk): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $optimizedFilename = $filename.'_optimized_'.time().'.'.$extension;

        return 'optimized/'.$optimizedFilename;
    }

    /**
     * Get file size in human readable format
     */
    public function getFileSize(string $path, string $disk = 'public'): string
    {
        $fullPath = Storage::disk($disk)->path($path);

        if (! file_exists($fullPath)) {
            return '0 B';
        }

        $bytes = filesize($fullPath);
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2).' '.$units[$i];
    }

    /**
     * Check if file is an image
     */
    public function isImage(UploadedFile $file): bool
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        return in_array($file->getMimeType(), $allowedMimes);
    }
}
