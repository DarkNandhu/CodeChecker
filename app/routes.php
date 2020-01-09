<?php
//error_reporting(0);
require 'start.php';

//use Codechecker\UsersController;
use Codechecker\Controller\CodeController;
use Codechecker\JSON\OpConverter;

//$user = new UsersController();
$code = new CodeController();
$op = new OpConverter();

switch($_GET['uri']){
    case "check/code":
      $output = $code->CheckCode($_POST['code'], $_POST['input'], $_POST['lang']);
      if(is_array($output)){
        if($output[1] == -1)
        $op->ConvertOp(300, $output[0], null, "OOPS Compilation Error");
        else if($output[1] == -2)
        $op->ConvertOp(301, $output[0], null, "OMG Run Time Error");
      }
      else
       $op->ConvertOp(200, $output, null, "Congratulations Your code works!!");

    break;

    
}