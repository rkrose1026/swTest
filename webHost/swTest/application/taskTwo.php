<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SweetwaterTest Task 2 - Rrose</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">

<link href="/scripts/css/sw.css" rel="stylesheet" type="text/css" />

</head>

<body>
<span class="header">Ryan Rose<BR>Sweetwater Test Task 2</span>

<div class="contentContainer">
    <div class="buttonContainer">
        <a href="../index.php" class="button button1">Back to Home</a>
        <a href="/application/taskOne.php" class="button button1">Task 1 - Report</a>
    </div>
</div>

<span class="header">Update Shipping Dates</span>

<div class="contentContainer">
    <p>Handled in PHP & MySQL.</p>
    <p>Giving a couple of options below</p>
    <p>Assuming values are following "Expected Ship Date: "</p>
    <p>Could be done in PHP, by pulling the data, going through and pulling out the comments that had the expected ship by date, then writing them back to the table, that could be done in a few ways, but I decided to go the route of having MySQL do the heavy lifting.</p>
    <p>Decided to go ahead an build out a PHP route</p>
</div>

<form action="/application/taskTwo.php" method="POST" id="form">


<div class="contentContainer">
    <button id="" name="request" type="submit" value="zeroData" class="button button1">Zero Out Shipdate Fields in MySQL</button>
    <button id="" name="request" type="submit" value="mysql" class="button button1">MYSQL Pull Dates From Comments and Populate</button>
    <button id="" name="request" type="submit" value="php" class="button button1">PHP Pull Dates From Comments and Populate</button>

<?php
require_once ($_SERVER["DOCUMENT_ROOT"]. '/../../config/includes/includes.php');
require_once (SERVICES_DIRECTORY . '/SweetwaterTestService.php');

if(!empty($_POST)){
    if(!empty($_POST['request'])){
        $request = $_POST['request'];

        $db = new LocalhostDB;
        $sweetwaterTestService = new SweetwaterTestService($db);

        if($request == 'zeroData'){
            $sweetwaterTestService->mysqlRevertShipdate();
        
        } else if($request == 'mysql'){
             $sweetwaterTestService->mysqlUpdateShipdate();

        } else if($request == 'php'){

            $allData = $sweetwaterTestService->getAllData();

            foreach($allData as $key=>$data){
                $order = $data->getOrderid();
                $comment = $data->getComments();
                
                $needle = 'Expected Ship Date: ';

                if (($pos = strpos($comment, $needle)) !== FALSE) {
                   
                    $strArr = explode($needle, $comment);
                    if(count($strArr) == 2){
                        $date = substr($strArr[1], 0,8);
                    }

                    $sweetwaterTestService->phpUpdateShipdate($order, $date);

                }
            }
        }
        $return = $sweetwaterTestService->getAllData();

        echo "<table border=1 cellspacing=0 cellpadding=10>";
        foreach($return as $key=>$data){
            echo '<tr><td style="width:10%">'.$data->getOrderid().'</td><td style="width:50%";>'.$data->getComments().'</td><td>'.$data->getShipdateExpected().'</td></tr>';
        }
        echo '</table>';

    }
}

?>

</div>
</form>
</body>
</html>