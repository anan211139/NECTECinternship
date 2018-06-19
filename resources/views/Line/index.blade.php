<h1>hello world </h1>
<?php
    //------QR CODE-----------
    $userId="U038940166356c6b9fb0dcf051aded27f";
    $_REQUEST['data'] = $userId;
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'phpqrcode/temp'.DIRECTORY_SEPARATOR; 
    //html PNG location prefix
    $PNG_WEB_DIR = 'phpqrcode/temp/';
    include "phpqrcode/qrlib.php";    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
        $filename = $PNG_TEMP_DIR.'test.png';
        $errorCorrectionLevel = 'L';
        $matrixPointSize = 4;
    if (isset($_REQUEST['data'])) { 
        //it's very important!
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="?">back</a>');
        // user data
        $filename = $PNG_TEMP_DIR.$_REQUEST['data'].'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2); 

    } else {    
        //default data
        echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
    }         
    //display generated file
    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';  
    $img_qr = basename($filename);
?>
