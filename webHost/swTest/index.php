<?php

require_once ($_SERVER["DOCUMENT_ROOT"]. '/../../config/includes/includes.php');
require_once (SERVICES_DIRECTORY . '/SweetwaterTestService.php');


$db = new LocalhostDB;
$sweetwaterTestService = new SweetwaterTestService($db);

$test = $sweetwaterTestService->getAllData();

echo "<Pre>";
print_r($test);
echo "</PRE>";


?>