<?php
function stop(){
  echo json_encode((Object)Array());
  exit;
}
function sendMessage($channelID, $message){
  $response = (Object)Array(
    "to" => $channelID, 
    "message" => $message
  );
  echo json_encode($response);
  exit();
}

function runComplexCommand($channelID, $message, $command, $callback) {
  if (substr($message, 0, strlen($command)) == $command){
    $usermessage = trim(substr($message, strlen($command), strlen($message) - strlen($command)));
    $callback($channelID, $message, $usermessage);
  }
}

function runSimpleCommand($channelID, $message, $command, $response) {
  if (substr($message, 0, strlen($command)) == $command){
    sendMessage($channelID, $response);
  }
}
?>
