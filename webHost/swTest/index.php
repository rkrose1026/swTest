<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SweetwaterTest - Rrose</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">

<link href="/scripts/css/sw.css" rel="stylesheet" type="text/css" />

</head>

<body>
<span class="header">Ryan Rose<BR>Sweetwater Test</span>


<form action="/index.php" method="POST" id="form">

<div class="contentContainer">
    <div class="buttonContainer">
        <a href="/application/taskOne.php" class="button button1">Task 1 - Report</a>
        <a href="/application/taskTwo.php" class="button button1">Task 2 - Shipdate</a>

<?php
require_once ($_SERVER["DOCUMENT_ROOT"]. '/../../config/includes/includes.php');
require_once (SERVICES_DIRECTORY . '/SweetwaterTestService.php');

$data = '';
$buttonHtml = '<button id="" name="request" type="submit" value="allData" class="button button1">View Table Data</button>';

if(!empty($_POST)){
    if(!empty($_POST['request'])){
        $request = $_POST['request'];
        
        if($request == 'allData'){

            $db = new LocalhostDB;
            $sweetwaterTestService = new SweetwaterTestService($db);

            $allData = $sweetwaterTestService->getAllData();

            $data = $allData;
            $buttonHtml = '<button id="" name="request" type="submit" value="clear" class="button button1">Hide Table Data</button>';
        }
    }
}

echo $buttonHtml;

?>

    </div>
</div>
</form>


<div c<div class="contentContainer">
    <?php
        echo "<Pre>";
        print_r($data);
        echo "</PRE>";
    ?>
</div>


</body>
</html>