<?php
//Class declaration
class EmployeeWage
{
	//Default constructor to display welcome meaasge
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

		//Opening file with read mode
		$file = fopen("employee_wage.csv", "r");

		//Loop with condition of checking data of file and loop will terminate if file data ends
		while (($data = fgetcsv($file)) !== false)
		{
			//Checking employee name
			if($data[0]==$employee_name)
			{

				//Displaying details
        	
                echo " ".$data[1]." ".$data[2]." ". $data[3]."\n";

        		$day++;
        	}
			
		}
		

		//Closing the file
		fclose($file);

	}

}

//Object creation
$object= new EmployeeWage();

//Calling methods with employee name
$object->calculate_wage("Sachin");

?>