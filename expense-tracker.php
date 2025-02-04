<?php

require_once "src/fileFunctions.php";
require_once "src/expenseFunctions.php";

function showUsage($message = "") {
    if($message){
        echo "{$message} \n";
    }

    echo "Usage: php task-cli.php <command> [options]\n";
    exit(1);
}

function getNumericArgument($index)
{
    global $argv;
    return isset($argv[$index]) && is_numeric($argv[$index]) ? $argv[$index] : null;
}

if($argc < 2){
    showUsage("No command provided.");
}

$command = $argv[1];
$description = isset($argv[2]) ? $argv[2] : null;
$option = isset($argv[3]) ? $argv[3] : null;
$description2 = isset($argv[4]) ? $argv[4] : null;
$option2 = isset($argv[5]) ? $argv[5] : null;


//need to add checking data before function
$commands = [
    "list" => function() use ($description, $option){
        loadEpneses();
    },
    "summary" => function(){
        summary();
    },
    "add" => function() use ($description, $option , $description2, $option2){
        addExpense((float) $option2,$option);
    },
    "delete" => function() use ($description, $option){
        deleteExpense($option);
    }
];

if (array_key_exists($command, $commands)) {
    $commands[$command]();
} else {
    showUsage("Error: Invalid command.");
}