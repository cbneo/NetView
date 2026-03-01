<?php
require "/../needed/scripts.php";
$video_info = $conn->prepare("SELECT * FROM videos LEFT JOIN users ON users.uid = videos.uid WHERE vid = ? AND converted = 1 AND users.termination = 0");
$video_info->execute([$_GET['video_id']]);
if ($video_info->rowCount() == 0) {
 die();
}
$is_flash = false;

if(isset($_GET['format']) && $_GET['format'] == "webm") {
	$filename = __DIR__ . "/data/videos/" . $_GET['video_id'] . ".webm";
} else {
	$filename = __DIR__ . "/data/videos/" . $_GET['video_id'] . ".flv";
	$is_flash = true;
}
// $down_name = str_replace("/data/videos/", "",$filename);
header("Content-Description: File Transfer"); 
header("Content-Type: application/octet-stream"); 
header("Content-Disposition: attachment; filename=\"". basename($filename) ."\""); 
function set_range($range, $filesize, &$first, &$last){
	
	$dash=strpos($range,'-');
	$first=trim(substr($range,0,$dash));
	$last=trim(substr($range,$dash+1));
	if ($first=='') {
  
	  $suffix=$last;
	  $last=$filesize-1;
	  $first=$filesize-$suffix;
	  if($first<0) $first=0;
	} else {
	  if ($last=='' || $last>$filesize-1) $last=$filesize-1;
	}
	if($first>$last){
  
	  header("Status: 416 Requested range not satisfiable");
	  header("Content-Range: */$filesize");
	  exit;
	}
  }
  
  function buffered_read($file, $bytes, $buffer_size=1024){
	/*
	Outputs up to $bytes from the file $file to standard output, $buffer_size bytes at a time.
	*/
	$bytes_left=$bytes;
	while($bytes_left>0 && !feof($file)){
	  if($bytes_left>$buffer_size)
		$bytes_to_read=$buffer_size;
	  else
		$bytes_to_read=$bytes_left;
	  $bytes_left-=$bytes_to_read;
	  $contents=fread($file, $bytes_to_read);
	  echo $contents;
	  flush();
	}
  }
  
  function byteserve($filename){
	/*
	Byteserves the file $filename.  
  
	When there is a request for a single range, the content is transmitted 
	with a Content-Range header, and a Content-Length header showing the number 
	of bytes actually transferred.
  
	When there is a request for multiple ranges, these are transmitted as a 
	multipart message. The multipart media type used for this purpose is 
	"multipart/byteranges".
	*/
  
	$filesize=filesize($filename);
	$file=fopen($filename,"rb");
  
	$ranges=NULL;
	if ($_SERVER['REQUEST_METHOD']=='GET' && isset($_SERVER['HTTP_RANGE']) && $range=stristr(trim($_SERVER['HTTP_RANGE']),'bytes=')){
	  $range=substr($range,6);
	  $boundary='g45d64df96bmdf4sdgh45hf5';//set a random boundary
	  $ranges=explode(',',$range);
	}
  
	if($ranges && count($ranges)){
	  header("HTTP/1.1 206 Partial content");
	  header("Accept-Ranges: bytes");
	  if(count($ranges)>1){
  
  
		//compute content length
		$content_length=0;
		foreach ($ranges as $range){
		  set_range($range, $filesize, $first, $last);
		  $content_length+=strlen("\r\n--$boundary\r\n");
		  $content_length+=strlen("Content-type: video/mp4\r\n");
		  $content_length+=strlen("Content-range: bytes $first-$last/$filesize\r\n\r\n");
		  $content_length+=$last-$first+1;          
		}
		$content_length+=strlen("\r\n--$boundary--\r\n");
  
		//output headers
		header("Content-Length: $content_length");
  
		header("Content-Type: multipart/x-byteranges; boundary=$boundary");
  
  
		foreach ($ranges as $range){
		  set_range($range, $filesize, $first, $last);
		  echo "\r\n--$boundary\r\n";
		  echo "Content-type: video/mp4\r\n";
		  echo "Content-range: bytes $first-$last/$filesize\r\n\r\n";
		  fseek($file,$first);
		  buffered_read ($file, $last-$first+1);          
		}
		echo "\r\n--$boundary--\r\n";
	  } else {
  
		$range=$ranges[0];
		set_range($range, $filesize, $first, $last);  
		header("Content-Length: ".($last-$first+1) );
		header("Content-Range: bytes $first-$last/$filesize");
		header("Content-Type: video/mp4");  
		fseek($file,$first);
		buffered_read($file, $last-$first+1);
	  }
	} else{
  
	  header("Accept-Ranges: bytes");
	  header("Content-Length: $filesize");
	  header("Content-Type: video/mp4");
	  readfile($filename);
	}
	fclose($file);
  }
  
  function serve($filename, $download=0){
	//Just serves the file without byteserving
	//if $download=true, then the save file dialog appears
	$filesize=filesize($filename);
	header("Content-Length: $filesize");
	header("Content-Type: video/mp4");
	$filename_parts=pathinfo($filename);
	if($download) header('Content-disposition: attachment; filename='.$filename_parts['basename']);
	readfile($filename);
  }
  
  
//  set_magic_quotes_runtime(0);

if(file_exists($filename)) {
	if ($is_flash == true) {
		header("Content-Type: video/x-flv");
		$resource = fopen($filename, "rb");
		fpassthru($resource); 
	}
	else {
		ini_set('session.cache_limiter','none');
		byteserve($filename); 
	}
}
?>
