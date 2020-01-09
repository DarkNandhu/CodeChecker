<?php
namespace Codechecker\JSON;
header('Content-Type: application/json');
class OpConverter{

    public function ConvertOp($statuscode, $input, $tag = null, $message = null){
         $arra = array();
         $arra['success'] = $statuscode == 200 ? true : false;
         $arra['statusCode'] = $statuscode;
         $arra['responseData'] = is_array($input) ?( sizeof($input) > 1 ? array($tag => $input): isset($tag) ? array($tag => $input) : $input[0] ) : $input;
         $arra['message'] = $message == null ? "success" : $message;
         echo json_encode($arra);


    }
}