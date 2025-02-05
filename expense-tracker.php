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
$desc1 = $argv[2] ?? null;
$opt1 = $argv[3] ?? null;
$desc2 = $argv[4] ?? null;
$opt2 = $argv[5] ?? null;
$lengthofargv = $argc;

//need to add checking data before function
$commands = [
    "list" => function() use ($desc1, $opt1, $argc){
        if($argc > 2){
            $month = getNumericArgument(3);
            $monthNumber = intval($month);
            $month !== null  && $monthNumber >= 1 && $monthNumber <= 12 && $desc1 == "--month" ? 
            summaryMonthExpenses($opt1) : showUsage("Invalid month");
            return;
        }
        loadEpneses();
    },
    "summary" => function(){
        summary();
    },
    "add" => function() use ($opt1 , $opt2){
        addExpense((float) $opt2,$opti1);
    },
    "delete" => function() use ( $opt1){
        deleteExpense($opt1);
    }
];

if (array_key_exists($command, $commands)) {
    $commands[$command]();
} else {
    showUsage("Error: Invalid command.");
}