<?php

define("FILE_PATH", "data/expense.json");


function getExpenses() {
    
    if(!file_exists(FILE_PATH))
    {
        file_put_contents(FILE_PATH, json_encode([], JSON_PRETTY_PRINT));
        return [];
    }

    $data = file_get_contents(FILE_PATH);
    return json_decode($data, true);
}

function saveExpense($expense){
    $jsonData = json_encode($expense, JSON_PRETTY_PRINT);
    file_put_contents(FILE_PATH, $jsonData);
}