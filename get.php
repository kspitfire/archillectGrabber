<?php

require_once(__DIR__.'/ArchillectGrabber.php');

$currentOptions = getopt('i::',['stop::', 'start::', 'path::']);

$id = (int) $currentOptions['i'];
$path = ($currentOptions['path']) ?: __DIR__.'/archillect-images';
$start = (int) $currentOptions['start'];
$stop = (int) $currentOptions['stop'];

echo 'Starting ...'.PHP_EOL;

if (!file_exists($path) && is_writable($path)) {
	try {
	    mkdir($path);
	} catch(\Exception $ex) {
	    throw new \Exception(sprintf('Directory `%s` does not exists. Cannot create new, error message: `%s` ', $downloadFolder, $ex->getMessage()));
	}
}

$grabber = new ArchillectGrabber($path);

if (!empty($id) && empty($start) && empty($stop)) {
	echo sprintf("Saving %d ...", $id);
	$grabber->saveImage($id);
	echo 'Finished!'.PHP_EOL;
} else {
	$steps = abs($stop - $start);
	$min = ($start < $stop) ? $start : $stop;

	for ($i = $min; $i <= ($min + $steps) ; $i++) { 
		echo sprintf("Saving %d ...", $i);
		$grabber->saveImage($i);		
	}

	echo 'Finished!'.PHP_EOL;
}




