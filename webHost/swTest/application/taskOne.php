<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SweetwaterTest Task 1 - Rrose</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">

<link href="/scripts/css/sw.css?var=a" rel="stylesheet" type="text/css" />

</head>

<body>
<span class="header">Ryan Rose<BR>Sweetwater Test Task 1</span>


<div class="contentContainer">
    <div class="buttonContainer">
        <a href="../index.php" class="button button1">Back to Home</a>
        <a href="/application/taskTwo.php" class="button button1">Task 2 - Shipdate</a>
    </div>
</div>



<span class="header">Comments Report</span>

<div class="contentContainer">
    <p>Handled in PHP.</p>
    <p>Pulling in all data, then going through and pulling out the comments that contain the requested values, into their own arrays, leaving comments that aren't requested in the original.</p>
    <p>then running a quick function to output the array's comments into a table</p>
    <BR>
    <p>Do you guys send out a lot of candy? not many seem to enjoy cinnamon</p>
</div>
<div class="contentContainer">
<?php
    require_once ($_SERVER["DOCUMENT_ROOT"]. '/../../config/includes/includes.php');
    require_once (SERVICES_DIRECTORY . '/SweetwaterTestService.php');

    //Originally started doing the sort in MySQL but figured i'd give it a go in PHP land

    $db = new LocalhostDB;
    $sweetwaterTestService = new SweetwaterTestService($db);

    $allData = $sweetwaterTestService->getAllData();
    $commentsCandy = array();
    $commentsCall = array();
    $commentsReferred = array();
    $commentsSignature = array();

    foreach($allData as $key=>$data){
        $order = $data->getOrderid();
        $comment = $data->getComments();
        
        $commentLc = strtolower($comment);

        if(str_contains($commentLc, 'candy')){
            array_push($commentsCandy, $data);
            unset($allData[$key]);
        } else if(str_contains($commentLc, 'call')){
            array_push($commentsCall, $data);
            unset($allData[$key]);
        } else if(str_contains($commentLc, 'referred')){
            array_push($commentsReferred, $data);
            unset($allData[$key]);
        } else if(str_contains($commentLc, 'signature')){
            array_push($commentsSignature, $data);
            unset($allData[$key]);
        }
    }

    //Good Ol tables!
    echo "<table border=1 cellspacing=0 cellpadding=10>";
    
    printOut($commentsCandy, 'Comments Candy');
    printOut($commentsCall, 'Call Me / Dont Call Me');
    printOut($commentsReferred, 'Referred');
    printOut($commentsSignature, 'Signature');
    printOut($allData, 'Miscellaneous');


    function printOut($array, $header){
        foreach($array as $key=>$data){
            echo '<tr><td style="width:10%">'.$header.'</td><td>'.$data->getComments().'</td></tr>';
        }
    }

    echo '</table>';
?>

</div>




</body>
</html>