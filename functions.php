<?php
include_once 'config.php';

function get_remote_file_size($url)
{
	$ch = curl_init($url);
	
	curl_setopt($ch, CURLOPT_NOBODY, true);

	curl_exec($ch);
	return curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
}

function is_support_range_download($url)
{
	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_NOBODY, true);

	$headerString = curl_exec($ch);

	$headersArray = explode("\r\n", $headerString);

	foreach($headersArray as $header)
	{
		$headerArray = explode(":", $header) ;

		if(isset($headerArray[0]) &&
				strtolower(trim(($headerArray[0])))== strtolower('Accept-Ranges'))
			return true;
	}

	return false;
}

function download_range($url , $ip, $startByte, $endByte)
{
	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_INTERFACE, $ip);
	curl_setopt($ch, CURLOPT_RANGE, "$startByte-$endByte");

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	return curl_exec($ch);
}

function split_file_size($size, $count)
{
	$result = array();
	$slice = (int)( $size / $count );

	for($i=1; $i<= $count; $i++)
	{
		$result[$i]['start'] = ($i-1 ) * $slice;

		if($i == $count)
			$result[$i]['end'] = $size;
		else
			$result[$i]['end'] = (($i ) * $slice) -1;
	}

	return array_values($result);
}