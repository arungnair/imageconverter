<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use App\Console\Commands\imageConverionCommand;
use Illuminate\Http\Request;
use Image;
use Session;

class ImageConversionController extends Controller{

      public function index(){

        return view('resizeImage');
      }
//image resize function
      public function resizeImage(Request $request){
        $source = public_path($request->source);
        $destination = public_path($request->destination);
        $isUI=true;
        if($source == public_path()){
          $isUI=false;
        $source = public_path($request->request->get('input'));
        $destination = public_path($request->request->get('output'));
        }
        $files = scandir($source);
        foreach($files as $key => $value){
          if($value === '.' || $value === '..') {continue;}
            $image = $value;
            $input['imagename'] = time().'.'.$value;

            if($isUI){
               $width = $request->maxwidth;
               $height = $request->maxheight;
               $quality = $request->imgquality;
             }else{
               $width = $request->request->get('width');
               $height = $request->request->get('height');
               $quality = $request->request->get('quality');
             }
              $path = realpath($source.'\\'.$value);
              //$sourceImagePath = dirname($path);
              $sourceImagePath = $source;
              $sourceFilename = basename($path);
              $destImagePath = $destination;

              $this->generateResizedImages($sourceImagePath, $destImagePath, $sourceFilename, $width, $height, $quality);

              //*/

          }
          Session::flash('success', 'Images converted successfully!');
          return redirect('/');
        }

        function generateResizedImages($sourceImagePath, $destImagePath, $sourceFilename, $width, $height, $quality = 100){
        	$filename = $sourceImagePath.'\\'.$sourceFilename;
        	$resizedFilename = $destImagePath.'\\'.$sourceFilename;
        	// resize the image with 300x300
        	$imgData = $this->resize_image($filename, $width, $height);
        	// save the image on the given filename
        	// or according to the original format, use another method
        	$array = getimagesize($filename);
        	//Save based on file extension
        	if($array['mime'] == 'image/jpeg'){
        		imagejpeg($imgData, $resizedFilename, $quality);
        	}
        	else if($array['mime'] == 'image/png'){
        		$compression = round( $quality / 10);
        		$compression = $compression<10 ? $compression : 9;
        		imagepng($imgData, $resizedFilename, $compression);
        	}
        	else if($array['mime'] == 'image/gif'){
        		 imagegif($imgData, $resizedFilename, $quality);
        	}
        	return;
        }

        function resize_image($file, $w, $h, $crop=false) {
          $imageDetails = getimagesize($file);
          list($width, $height) = $imageDetails;
          $r = $width / $height;
          if ($crop) {
              if ($width > $height) {
                  $width = ceil($width-($width*abs($r-$w/$h)));
              } else {
                  $height = ceil($height-($height*abs($r-$w/$h)));
              }
              $newwidth = $w;
              $newheight = $h;
          } else {
              if ($w/$h > $r) {
                  $newwidth = $h*$r;
                  $newheight = $h;
              } else {
                  $newheight = $w/$r;
                  $newwidth = $w;
              }
          }

          //Get file extension
          $exploding = explode(".",$file);
          $ext = end($exploding);
      	$mime = $imageDetails['mime'];
          switch($mime){
              case "image/png":
                  $src = imagecreatefrompng($file);
              break;
              case "image/jpeg":
              case "image/jpg":
                  $src = imagecreatefromjpeg($file);
              break;
              case "image/gif":
                  $src = imagecreatefromgif($file);
              break;
              default:
                  $src = imagecreatefromjpeg($file);
              break;
          }

          $dst = imagecreatetruecolor($newwidth, $newheight);
          imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

          return $dst;
      }
    }
