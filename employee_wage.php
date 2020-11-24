<?php
//Setting log_error as true
ini_set("log_errors",TRUE);
//Setting error.log file into php.ini file 
$log_file="error.log";		// Getting filename of log file into a variable
ini_set("error_log",$log_file);

//Class declaration
class EmployeeWage
{
	Protected $employee_data=array();
	//Default constructor to display welcome message
	public function __construct()
	{
		echo "=======================================";
		echo "\n Welcome to Employee Wage Program \n";
		echo "=======================================\n";

	}

	//Method for calculating employee wage
	public function calculate_wage($employee_name)
	{
		//Declaring variables
		$total_working_hours=0;
		$total_wage=0;
		$rate_per_hour=20;
		$day=0;

		//Error handling to check whether the file is exists or not.
		//It is important to have a csv file to read data from there.
		try
		{
			if(!file_exists("employee_wage.csv"))		//Checking file exists or not
			{
				throw new Exception("employee_wage.csv was not found"); 		//Throwning exception
			}
			else
			{
				//Opening file with read mode
				$file = fopen("employee_wage.csv", "r");
				//Loop with condition of checking data of file and loop will terminate if file data ends
				while (($data = fgetcsv($file)) !== false)
				{
					//Checking employee name
					if($data[0]==$employee_name)
					{
						//Getting values on variable
						$attendance=$data[2];
						$hours=$data[3];

						//Checking Employee attandance
						if($attendance>0)
						{
							//Calculation to get per day wage according to work done hours and rate per hour
							$daily_wage=$rate_per_hour*$hours;
						}
						else
						{
							$daily_wage=0;
						}

						$total_wage+=$daily_wage;					//Calculating total wage

						$total_working_hours+=$hours;				//Calculating total number of working hours

						$day++;
        			}
				}
			}
		}
		catch(Exception $err)			//Handling exception and storing error 
		{
			
			$error_message=$err->getMessage();		//Storing Error message thrown by try block
			error_log($error_message);		//Storing error message into log file
			exit();
		}	

		//Putting output as associative array format
        $this->employee_data[]=array("employee_name"=>$employee_name, "total_working_hours"=>$total_working_hours, "total_wage"=>$total_wage);

		fclose($file);				//Closing the file

	}
	function put_json_output()
	{

		//Checking whether file exists or not
		if(!file_exists("employee_wage_output.json"))
		{
			touch("employee_wage_output.json");			//Creating file if not exists
			$json_file="employee_wage_output.json";		//Getting filename into variable
		}
		else
		{
			$json_file="employee_wage_output.json";		//Getting filename into variable
		}
		//Getting old data from file
		$old_json_data = file_get_contents($json_file);

		//Checking if is not empty
		if($old_json_data!=null)
		{
			//Merging old data with new data
			$old_data = json_decode($old_json_data);
			array_push($old_data, $this->employee_data);

			//Converting data into json format
			$json_data = json_encode($old_data);
		}
		else
		{
			//Converting data into json format
			$json_data = json_encode($this->employee_data);
		}
		
		//Putting json data into output file
		file_put_contents($json_file, $json_data);

	}

}

$employee_wage_object= new EmployeeWage();					//Object creation
//Calling methods with different employee names
$employee_wage_object->calculate_wage("Sachin");
$employee_wage_object->calculate_wage("Satish");
$employee_wage_object->calculate_wage("Manoj");
$employee_wage_object->calculate_wage("Ramesh");
$employee_wage_object->calculate_wage("Mukul");
$employee_wage_object->put_json_output();

?>