<?php
$argv = array(
	'ip2region.db',
	'binary',
);

$dbFile     = $argv[0];
	//print_r($argv);exit;
$method     = 'btreeSearch';
$algorithm  = 'B-tree';
if ( isset($argv[1]) ) {
    switch ( strtolower($argv[1]) ) {
    case 'binary':
        $algorithm = 'Binary';
        $method    = 'binarySearch';
        break;
    case 'memory':
        $algorithm = 'Memory';
        $method    = 'memorySearch';
        break;
    }
}

require dirname(__FILE__) . '/Ip2Region.class.php';
$ip2regionObj = new Ip2Region($dbFile);


while ( true ) {
    $line = '106.19.7.205';
    $data   = $ip2regionObj->{$method}($line);
    print_r($data);exit;
}

?>
