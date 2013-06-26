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