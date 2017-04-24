<?php
// amcharts.com export to image utility
// set image type (gif/png/jpeg)
$imgtype = 'jpeg';

// set image quality (from 0 to 100, not applicable to gif)
$imgquality = 100;

// get data from $_POST or $_GET ?
//$data = &$_POST;
$inter_data = explode("&",$_POST['data']);
foreach($inter_data as $value){
    $arrTemp = explode("=",$value);
    $data[$arrTemp[0]]= $arrTemp[1];
}
$data['width']=$_POST['width'];
$data['height']=$_POST['height'];
$data['save']=$_POST['save'];

// set this to file name in order to save file instead of streaming
//$data['save'] = $data['save'];

// define base directory for save operations (if aplicable)
$base_dir = dirname(__FILE__); // default is the same directory as export.php

// stream or save the image on server
$save = false;
if (isset($data['save']) && $data['save'] != '') {
  // format URI
  str_replace('\\', '/', $data['save']);
  $save = str_replace('//', '/', $base_dir.'/'.$data['save']);
  
  // append extention
  if (!preg_match('/\.[a-z]+$/i', $save)) {
    if ($imgtype == 'jpeg') {
      $save .= '.jpg';
    }
    else {
      $save .= '.'.$imgtype;
    }
  }
}

// get image dimensions
$width  = (int) $data['width'];
$height = (int) $data['height'];

// create image object
$img = imagecreatetruecolor($width, $height);

// populate image with pixels
for ($y = 0; $y < $height; $y++) {
  // innitialize
  $x = 0;
  
  // get row data
  $row = explode(',', $data['r'.$y]);
  
  // place row pixels
  $cnt = sizeof($row);
  for ($r = 0; $r < $cnt; $r++) {
    // get pixel(s) data
    $pixel = explode(':', $row[$r]);
    
    // get color
    $pixel[0] = str_pad($pixel[0], 6, '0', STR_PAD_LEFT);
    $cr = hexdec(substr($pixel[0], 0, 2));
    $cg = hexdec(substr($pixel[0], 2, 2));
    $cb = hexdec(substr($pixel[0], 4, 2));
    
    // allocate color
    $color = imagecolorallocate($img, $cr, $cg, $cb);
    
    // place repeating pixels
    $repeat = isset($pixel[1]) ? (int) $pixel[1] : 1;
    for ($c = 0; $c < $repeat; $c++) {
      // place pixel
      imagesetpixel($img, $x, $y, $color);
      
      // iterate column
      $x++;
    }
  }
}

if ($save){
  // save
  $function = 'image'.$imgtype;
  if ($imgtype == 'gif') {
    $function($img, $save);
  }
  else {
    $function($img, $save, $imgquality);
  }
 /*echo "<img src='".$data['save']."' />";*/
}
else {
  // stream  
  // set proper content type
  header('Content-type: image/'.$imgtype);
  header('Content-Disposition: attachment; filename="chart.'.$imgtype.'"');
  
  // stream image
  $function = 'image'.$imgtype;
  if ($imgtype == 'gif') {
    $function($img);
  }
  else {
    $function($img, null, $imgquality);
  }
}

// destroy
imagedestroy($img);
?>