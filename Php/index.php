<?php
include 'basiclib.php';
$postdata = file_get_contents('php://input');
$apiData = json_decode($postdata, true);
$channelID = $apiData['channelID'];
$message = $apiData['message'];

include 'AddRemoveSimple.php';

$commands = (array)json_decode(file_get_contents("simplecommands.json"), true);
foreach ($commands as $command){
  runSimpleCommand($channelID, $message, $command['command'], $command['message']);
}
exit;
?>
