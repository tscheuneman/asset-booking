<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use File;
use App\Asset;
use Intervention\Image\ImageManager;


class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fileLoc;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileLocation)
    {
        $this->fileLoc = $fileLocation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $manager = new ImageManager(array('driver' => 'imagick'));

        $img = $manager->make(public_path(). '/storage/' . $this->fileLoc)->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(public_path(). '/storage/' . $this->fileLoc, 60);

    }
}
