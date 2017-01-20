<?php

require_once 'vendor/autoload.php';


//create unplag client
$unplag = new Unplag\Unplag('YOUR-API-KEY', 'YOUR-API-SECRET');


//upload file
$testText = <<<EOF
PHP code may be embedded into HTML code, or it can be used in combination with various web template systems, web content management systems and web frameworks.
PHP code is usually processed by a PHP interpreter implemented as a module in the web server or as a Common Gateway Interface (CGI) executable.
The web server combines the results of the interpreted and executed PHP code, which may be any type of data, including images, with the generated web page.
PHP code may also be executed with a command-line interface (CLI) and can be used to implement standalone graphical applications.
EOF;

try
{
	$file = $unplag->fileUpload(\Unplag\PayloadFile::bin($testText), 'txt');
}
catch (Unplag\Exception\UnplagException $e)
{
	echo $e;
	die('File upload error: ' . $e->getMessage() . PHP_EOL);
}

echo 'File uploaded!' . PHP_EOL;
var_dump($file);



//start check
$checkParam = new \Unplag\Check\CheckParam($file['id']);
$checkParam->setType(\Unplag\Check\CheckParam::TYPE_WEB);

try
{
	$check = $unplag->checkCreate($checkParam);
}
catch (Unplag\Exception\UnplagException $e)
{
	die('Check start fail: ' . $e->getMessage() . PHP_EOL);
}

echo 'Check started!' . PHP_EOL;
var_dump($check);

