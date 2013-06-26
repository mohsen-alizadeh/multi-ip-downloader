#!/usr/bin/php
<?php

include_once 'config.php';
include_once 'functions.php';


$url = $argv[1];
$output = basename($url);

if(!is_support_range_download($url))
	die("link does`nt support range download\n");


$file_size = get_remote_file_size($url);
$ip_count = count($ip);
$sizes = split_file_size($file_size, $ip_count);


for($i=0; $i < $ip_count; $i++)
{

	$pid = pcntl_fork();
	if ($pid == -1) {
		die('could not fork');
	} else if ($pid) {
		// we are the parent
		pcntl_wait($status); //Protect against Zombie children
	} else {
		// we are at the child
		$data = download_range($url, $ip[$i], $sizes[$i]['start'], $sizes[$i]['end']);
		file_put_contents(FILES_DIR . $output . '.' . $i, $data);
		die();
	}
}

while(1)
{
	sleep(1);
	$downloaded_parts = 0;
	
	for($i=0; $i<$ip_count; $i++)
	{
		if(file_exists(FILES_DIR . $output . '.' . $i))
			$downloaded_parts ++;
	}
	
	if($downloaded_parts == $ip_count)
	{
		for($i=0; $i<$ip_count; $i++)
		{
			file_put_contents(FILES_DIR . $output, 
								file_get_contents(FILES_DIR . $output . '.' . $i),
								FILE_APPEND
			);
			
			unlink(FILES_DIR . $output . '.' . $i);
		}
		
		die("Download completed\n");
	}
	
}