<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ImageConversionController;
use Illuminate\Http\Request;

class imageConverionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name {inputSrc}{outputSrc}{width}{height}{quality}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $ObjImageConversion;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Request $request)
    {
        //
        $input      = $this->argument('inputSrc');
        $output     = $this->argument('outputSrc');
        $width      = $this->argument('width');
        $height     = $this->argument('height');
        $quality    = $this->argument('quality');
        $request->request->add(['input' => $input,
                                'output' => $output,
                                'width' => $width,
                                'height' => $height,
                                'quality' => $quality]);

        $controller = new ImageConversionController();
        $controller->resizeImage($request);
    }
}
