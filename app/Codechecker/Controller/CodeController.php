<?php
namespace Codechecker\Controller;


class CodeController{

    public function CheckCode($code, $input, $lang){
        $file = $this->FileCreater($lang, $code);
        $output = $this->Compile($file, $lang);
        if($output == NULL){
            return $this->Run($file, $lang, $input);
        }
        else 
            return [$output, -1];


    }
//Executor
    public function Initiator($lang, $file){
	switch($lang){
		case "c":
			return 'TempCode/./'.explode(".", $file)[0];
		break;
		
		case "c++":
		    return 'TempCode/./'.explode(".", $file)[0];
		break;
		case "java":
			return 'java TempCode.'.explode(".", $file)[0];
		break;
		case "python":
			return 'python TempCode/'.$file;
		break;
		case "php":
			return 'php TempCode/'.$file;
        break;
        case "ruby":
			return 'ruby TempCode/'.$file;
        break;
        case "javascript":
			return 'node TempCode/'.$file;
		break;
	}
    }
//Generic Running script
    public function Run($file, $lang, $input){
        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe" , "w") 
         );

         $initiator = $this->Initiator($lang, $file);
 

         
            $process = proc_open($initiator, $descriptorspec, $pipes, $input);

            if(is_resource($process)){

                fwrite($pipes[0], $_POST['input']);
                fclose($pipes[0]);
                $output = stream_get_contents($pipes[1]);
                fclose($pipes[1]); 
                $error = stream_get_contents($pipes[2]);
                $this->Clean('TempCode/'.$file.'.*', $lang);
                if($error != "")
                    return [$error, -2];
                 else
                    return $output;
                $return_value = proc_close($process);
                
            }
    }
//Generic Contains checker
    public function str_contains($str, $checks){
		foreach($checks as $check){
			$pos = strpos($str, $check);
			if($pos !== false)
				return $pos;
		}
		return 0;
		
	}
//File Creator
    public function FileCreater($lang, $code){
        $fileName = 'N'.md5(date("dmyhis"));
		
		switch($lang){
			case "c":
				$fileName = $fileName.'.c';
			break;
			
			case "c++":
				$fileName = $fileName.'.cpp';
			break;
			
			case "java":
				mkdir('TempCode/'.$fileName, 0777, true);
				$classpos = stripos($code, "public class ");
				$class = '';
				for($i = $classpos+13; $i<strlen($code); $i++){
					if($code[$i] == '{')
						break;
					else {
						$class = $class.$code[$i];
					}
				}
				$to_check = array('extends', 'implements');
				$returned_from_checker = $this->str_contains($class, $to_check);
				if($returned_from_checker != 0)
					$class  = substr($class, 0 ,$returned_from_checker);
				$code = 'package TempCode.'.$fileName.'; '.$code;
				$fileName = $fileName.'/'.str_replace(' ', '', $class).'.java';
			break;
			case "python":
				$fileName = $fileName.'.py';
			break;
			
			case "php":
				$fileName = $fileName.'.php';
            break;
            
            case "ruby":
                $fileName = $fileName.'.rb';
            break;

            case "javascript":
                $fileName = $fileName.'.js';
            break;
			
		}

        file_put_contents('TempCode/'.$fileName, $code);

        return $fileName;
        
    }
//Compile or Pre-Process program
    public function Compile($fileName, $lang){
       if($lang == "c")
          return shell_exec("gcc TempCode/".$fileName." -o TempCode/".explode(".",$fileName)[0]." 2>&1");
       else if($lang == "c++")
          return shell_exec("g++ TempCode/".$fileName." -o TempCode/".explode(".",$fileName)[0]." 2>&1");
       else if($lang == "java")
            return shell_exec("javac TempCode/".$fileName." 2>&1");
       else
            return shell_exec("chmod a+x TempCode/".$fileName." 2>&1");
    
    }

    public function Clean($fileName, $lang){
        if($lang == "java")
        shell_exec('rm -f '.substr($fileName, 0, strripos($fileName, '/')));
        else {
        foreach (glob($fileName) as $value) {
            unlink($value);
        }

        foreach (glob(explode(".",$fileName)[0]) as $value) {
            unlink($value);
        }
    }

    }
}


