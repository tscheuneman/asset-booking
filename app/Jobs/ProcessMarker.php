<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use File;
use Intervention\Image\ImageManager;
use Mockery\Exception;

class ProcessMarker implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileLocation)
    {
        $this->markerLoc = $fileLocation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $manager = new ImageManager(array('driver' => 'imagick'));
        try {
            $img = $manager->make(public_path(). '/storage/' . $this->fileLoc)->resize(14, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(public_path(). '/storage/' . $this->fileLoc, 60);
        }
        catch (Exception $e) {
            report($e);
        }
    }
}
