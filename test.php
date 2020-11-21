<?php
// echo phpinfo();

// try {
//     if (!file_exists("employee_wage2.csv")) {
//         throw new Exception("employee_wage2.csv was not found");
//     }
//     else{
//         echo "success";
//     }
// } catch(Exception $err)
// {
//     $log_file="error.log";
//     $error_message=$err->getMessage();
//     ini_set("log_errors",TRUE);
//     ini_set("error_log",$log_file);
//     error_log($error_message);
// }


if (!file_exists('somefile.php')) {
    touch('somefile.php');
}
    
?>