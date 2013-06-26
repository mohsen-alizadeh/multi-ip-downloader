<?php
include_once 'config.php';

function get_remote_file_size($url)
{
	$ch = curl_init($url);
	
	curl_setopt($ch, CURLOPT_NOBODY, true);

	curl_exec($ch);
	return curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
}
