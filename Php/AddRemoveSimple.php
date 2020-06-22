<?php
function removeCommand($channelID, $message, $usermessage){
  $index = strpos($usermessage, " ", 0);
  $command = substr($usermessage, 0, $index);
  $action = substr($usermessage, $index, strlen($usermessage) - $index);
  $commands = (array)json_decode(file_get_contents("simplecommands.json"), true);
  $newCommands = Array();
  foreach ($commands as $command){    
    if ($command['command'] != $usermessage){
      array_push($newCommands, $command);
    }
  }
  file_put_contents("simplecommands.json", json_encode($newCommands));
}

runComplexCommand($channelID, $message, "!!add ", function($channelID, $message, $usermessage){
  $index = strpos($usermessage, " ", 0);
  $command = substr($usermessage, 0, $index);
  removeCommand($channelID, $message, $command);
  $action = substr($usermessage, $index, strlen($usermessage) - $index);
  $commands = (array)json_decode(file_get_contents("simplecommands.json"), true);
  array_push($commands, Array(
    "command" => $command, 
    "message" => $action
  ));
  if ($command == "" || $command == null){
    sendMessage($channelID, "That didn't work");
    exit;
  }
  file_put_contents("simplecommands.json", json_encode($commands));
  sendMessage($channelID, "Command added!");
  exit;
});

runComplexCommand($channelID, $message, "!!delete ", function($channelID, $message, $usermessage){
  removeCommand($channelID, $message, $usermessage);
  sendMessage($channelID, "Command removed!");
  exit;
});
?>