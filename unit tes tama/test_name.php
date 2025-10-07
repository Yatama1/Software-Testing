<?php
// file test_age.php
require 'validator.php';

// test case 1 - valid age
try{
    $result = validateName("111111");
    echo "PASS : Nama Masuk akal.\n";
}catch (Exception $e){
    echo "FAIL : Nama Tidak masuk akal. Error : ". $e->getMessage() ."\n";

}