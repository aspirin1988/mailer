<?php
$session = YASF::$app->get("Session")->User('template');
?>
<!doctype html>
<html lang="en" ng-app="<?=$session?>">
<head>
    <meta charset="UTF-8">
    <link href="/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/libs/jquery/datepicker/css/datepicker.min.css" rel="stylesheet">
    <link href="/css/crm.css" rel="stylesheet" type="text/css">
    <link href="/libs/jquery/jquery-ui/css/jquery-ui.min.css" rel="stylesheet">
    <link href="/libs/simple-sidebar/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="/libs/jquery/datepicker/css/jquery.datetimepicker.css">
    <title><?=isset($title) ? $title : ""?></title>
    <?php
        if(isset($css)){
            foreach($css as $item){
                echo "\t<link rel=\"stylesheet\" href=\"/resources/$session/css/$item\">\n";
            }
        }
    ?>
</head>
<body>
