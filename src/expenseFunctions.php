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

// function loadDateExpenses() {
//     $expensses = checkexspenses();
//     foreach($expensses as $exp){
//         $date = $exp['date'];

//         $month = substr($exp, 5 ,2 );
//         if($month == "02"){
//             echo "Miesiąc: " . $month . "\n";
//         }
//     }
// }

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