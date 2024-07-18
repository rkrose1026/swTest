<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SweetwaterTest Task 1 - Rrose</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">

<link href="/scripts/css/sw.css?var=b" rel="stylesheet" type="text/css" />

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

<form action="/application/taskOne.php" method="POST" id="form">

<div class="contentContainer">
    <button id="" name="request" type="submit" value="group" class="button button1">Individual Groups</button>
    <button id="" name="request" type="submit" value="sort" class="button button1">Sort</button>

<?php
    require_once ($_SERVER["DOCUMENT_ROOT"]. '/../../config/includes/includes.php');
    require_once (SERVICES_DIRECTORY . '/SweetwaterTestService.php');

    //Originally started doing the sort in MySQL but figured i'd give it a go in PHP land
    
    function clean($string) {
        return preg_replace('/[^\x0A\x20-\x7E]/','',$string); 
    }

    function printOut($array, $header){
        $i = 1;
        $html = '';
        $html .= '<table border=1 cellspacing=0 cellpadding=10>';
        $html .= '<tr><td></td><td style="width:10%">Group</td><td style="width:10%">Order Id</td><td>Comments</td><td style="width:10%">Expected Ship Date</td></tr>';
            
        foreach($array as $key=>$data){
            $html .= '<tr><td>'.$i.'</td>';

            if($header == "grouping"){
                $grouping = $data->getGrouping();

                if($grouping == 'candy'){
                    $replacementHeader = 'Comments Candy';
                } else if ($grouping == 'call'){
                    $replacementHeader = 'Call Me / Dont Call Me';
                } else if ($grouping == 'referred'){
                    $replacementHeader = 'Referred';
                } else if ($grouping == 'signature'){
                    $replacementHeader = 'Signature';
                } else {
                    $replacementHeader = 'Miscellaneous';
                }
                
                $html .= '<td style="width:10%">'.$replacementHeader.'</td>';
            } else {
                $html .= '<td style="width:10%">'.$header.'</td>';
            }
            $html .= '<td style="width:10%">'.$data->getOrderid().'</td><td>'.clean($data->getComments()).'</td><td>'.$data->getShipdateExpected().'</td></tr>';
            $i++;
        }

        $html .= '</table>';

        return $html;
    }

if(!empty($_POST)){
    if(!empty($_POST['request'])){
        $request = $_POST['request'];

        $db = new LocalhostDB;
        $sweetwaterTestService = new SweetwaterTestService($db);
        
        $allData = $sweetwaterTestService->getAllData();

        if($request == 'group'){
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
            echo printOut($commentsCandy, 'Comments Candy');
            echo "<BR>";
            echo printOut($commentsCall, 'Call Me / Dont Call Me');
            echo "<BR>";
            echo printOut($commentsReferred, 'Referred');
            echo "<BR>";
            echo printOut($commentsSignature, 'Signature');
            echo "<BR>";
            echo printOut($allData, 'Miscellaneous');

        } else if($request == 'sort'){

            function customSort($a, $b) {
                $priority = [
                    "candy" => 1,
                    "call" => 2,
                    "referred" => 3,
                    "signature" => 4
                ];

                foreach ($priority as $str => $value) {
                    $foundA = stripos($a->getComments(), $str) !== false;
                    $foundB = stripos($b->getComments(), $str) !== false;

                    if ($foundA && !$foundB) {
                        $a->setGrouping($str);
                        return -1;
                    } else if (!$foundA && $foundB) {
                        $b->setGrouping($str);
                        return 1;
                    } else if($foundA && $foundB){
                        $a->setGrouping($str);
                        $b->setGrouping($str);
                    }
                }
               
                return 0;
            }

            usort($allData, 'customSort');

            echo printOut($allData, 'grouping');
        }
    }
}
?>



</div>
</form>


</body>
</html>