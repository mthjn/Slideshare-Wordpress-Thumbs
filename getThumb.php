<?php
$key = 'XXXXXXXX';
$sec = 'xxxxxxxx';
$t = time();
$str = $sec . $t;
$h = sha1($str);

$url = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';

$request = 'https://www.slideshare.net/api/2/get_slideshow?api_key='. $key
.'&ts='. $t
.'&hash='. $h
.'&slideshow_url='. $url;

$file = 'ss.xml';

$response = file_get_contents($request);

file_put_contents($file, $response);

$xml=simplexml_load_file($file);

echo $xml->ThumbnailURL;
