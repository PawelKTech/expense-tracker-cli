<?php

require_once "fileFunctions.php";


function checkexspenses(){
    $expensses = getExpenses();
    if(empty($expensses)){
        echo "No expenses found.\n";
        return;
    }
    return $expensses;
}


function loadEpneses() {
    $expensses = checkexspenses();
    foreach($expensses as $exp){
        echo "ID: ". $exp['id']. ", Amount: ". $exp['amount']. ", Description: ". $exp['description']. " Date: " . $exp['date']. "\n";
    }
    print_r($expensses);
}

function summaryMonthExpenses($userMonth) {
    $expensses = checkexspenses();
    $total = 0;

    foreach($expensses as $exp){
        $dateObj = new DateTime($exp['date']);
        $month = $dateObj->format('m');
        if(str_pad($userMonth, 2, "0", STR_PAD_LEFT) == $month){
            $total += $exp['amount'];
        }
    }
    $month = intval(str_pad($userMonth, 2, "0", STR_PAD_LEFT));
    $monthName = date('F', mktime(0,0,0, $month,1));

    echo "Total expenses for month {$monthName}: $total. \n";
}

function summary(){
    checkexspenses();
    $total = 0;

    foreach(checkexspenses() as $exp){
        $total += $exp['amount'];
    }
    echo "Total expenses: $total. \n";

}

function addExpense($amount, $description){
    $expensses = getExpenses();
    $date = date("Y-m-d");

    $newID = count($expensses) > 0 ? max(array_column($expensses, 'id')) + 1 : 1;

    $newExpense = [
        'id' => $newID,
        'description' => $description,
        'amount' => $amount,
        'date' => $date,
    ];
    $expensses[] = $newExpense;

    saveExpense($expensses);
    echo "Expense added successfully.\n";
}

function deleteExpense($id){
    $expensses = getExpenses();
    $index = array_search($id, array_column($expensses, 'id'));
    if($index === false){
        echo "Expense with ID $id not found.\n";
        return;
    }
    array_splice($expensses, $index, 1);
    saveExpense($expensses);
    echo "Expense deleted successfully.\n";
    loadEpneses($expensses); 
}