<?php
	$sLibraryPath = 'xmlmws.phar';
	$oPhar = new Phar($sLibraryPath); // creating new Phar
	$oPhar->setDefaultStub('index.php', 'index.php'); // pointing main file which require all classes
	$oPhar->buildFromDirectory('xmlmws'); // creating our library using whole directory
	$oPhar->compress(Phar::GZ); // plus - compressing it into gzip
?>