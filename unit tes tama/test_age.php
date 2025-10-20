<?php
// file test_age.php
require 'validator.php';

// test case 1 - valid age
try{
    $result = validateAge(19);
    echo "PASS : Umur 19 Masuk akal.\n";
}catch (Exception $e){
    echo "FAIL : Umur 19 Tidak masuk akal. Error : ". $e->getMessage() ."\n";
    
}