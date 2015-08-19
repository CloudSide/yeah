<?php

require_once(dirname(__DIR__) . '/class/Yeah.php');

$status = Yeah::yeah("/bin/bash", function($pid, $stdin, $stdout, $stderr) {
	
	fwrite($stdin, "echo 42.out\n");
	fwrite($stdin, "echo 42.err 1>&2\n");
	fclose($stdin);

	echo "pid    : " . $pid . "\n";
	echo "stdout : " . trim(fread($stdout, 1024)) . "\n";
	echo "stderr : " . trim(fread($stderr, 1024)) . "\n";
	
});

echo "status : " . trim(print_r($status, true)) . "\n";

