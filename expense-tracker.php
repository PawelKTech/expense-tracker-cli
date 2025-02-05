<?php

require_once "src/fileFunctions.php";
require_once "src/expenseFunctions.php";

function showUsage($message = "") {
    if($message){
        echo "{$message} \n";
    }
    echo "Open this link to show list of commands: https://github.com/PawelKTech/expense-tracker-cli \n"; 
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

$commands = [
    "list" => function() use ($argc){
        if($argc !== 2){
            showUsage();
            return;
        }
        loadEpneses();
    },
    "summary" => function() use($desc1, $opt1, $argc){
        if($argc > 2){
            $month = getNumericArgument(3);
            $monthNumber = intval($month);
            $month !== null && $monthNumber >= 1 && $monthNumber <= 12 && $desc1 == "--month" ? 
            summaryMonthExpenses($opt1) : showUsage("Invalid month");
            return;
        }
        summary();
    },
    "add" => function() use ($desc1, $desc2, $opt1 , $opt2){
        if(strlen($opt1) > 15){
            showUsage("Description is too long.");
            return;
        }
        $amount = getNumericArgument(5);
        $opt1 !== null && $desc1 == "--description" && $opt2 !== null && $desc2 == "--amount"?
        addExpense((float) $opt2,$opt1) : showUsage("Invalid command");
    },
    "delete" => function() use ($desc1, $opt1){
        $id = getNumericArgument(3);
        $desc1 == "--id" && $id !== null ? deleteExpense($opt1) : showUsage("Invalid command");
    }
];

if (array_key_exists($command, $commands)) {
    $commands[$command]();
} else {
    showUsage("Error: Invalid command.");
}