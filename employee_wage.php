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

				//Calculating total wage
				$total_wage+=$daily_wage;

				//Calculating total number of working hours
				$total_working_hours+=$hours;

				//Displaying details in tabular format
        	
                echo " ".$data[1]." ".$data[3]." ". number_format($daily_wage,2)."\n";

        		$day++;
        	}
		}
		

		//Closing the file
		fclose($file);

	}

}

//Object creation
$object= new EmployeeWage();

//Calling methods with different employee names
$object->calculate_wage("Sachin");
$object->calculate_wage("Satish");

?>