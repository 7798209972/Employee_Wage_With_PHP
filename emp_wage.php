<?php
//Class declaration
class EmployeeWage
{
	//Default constructor to display welcome meaasge
	public function __construct()
	{
		echo "=======================================";
		echo nl2br("\n Welcome to Employee Wage Program \n");
		echo "=======================================";

	}

	//Method to display total working hours and total calculated employee wage
	public function show_total_wage_and_working_hours($employee_name,$working_hours, $calculated_wage, $number_of_days)
	{
		echo nl2br(" Employee Name := $employee_name \n");
		echo nl2br(" Total Working Hours := $working_hours \n");
		echo nl2br(" Total Employee Wage for $number_of_days Days:= Rs.". number_format($calculated_wage,2)." /- \n");
		echo "=======================================";
	}

	//Method for calculating employee wage
	public function calculate_wage($employee_name)
	{
		//Declaring variables
		$total_hours=0;
		$total_wage=0;
		$rate_per_hour=20;
		$day=0;

		//Started HTML to use HTML tags
		echo "<html><style> table{ padding : 5px; } td,th{ border: inset 1px; padding: 5px; } </style><body><table>";

		//Started table tag for formatting
		echo "<table>";
		echo "<thead><tr><th>Day</th><th>No of working hours</th><th>Wage in Rs./-</th></tr></thead>";

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
				$total_hours+=$hours;


				//Displaying details in tabular format
        		echo "<tr>";
        	
                		echo "<td> " . $data[1]. "</td><td> " . $data[3]. "</td><td>" . number_format($daily_wage,2). "</td>";
        		echo "<tr>";

        		//Putting data for json in associative array format
        		$json_data[]=array("employee_name"=>$data[0], "day"=>$data[1], "working_hours"=>$data[3], "wage"=>$daily_wage);
        		$day++;
        	}
		}

		//Calling method to display total wage and working hours by passing variables
		$this->show_total_wage_and_working_hours($employee_name,$total_hours, $total_wage, $day);

		//Closing the file
		fclose($file);
		echo "</table></body></html>";

		//Opening Json file
		$json_file = file_get_contents('employee_wage_output.json');

		//Encoded data with json
		$encoded_data = json_encode($json_data);

		//Putting data into Json file
		file_put_contents('employee_wage_output.json', $encoded_data);
	}

}

//Object creation
$object= new EmployeeWage();

//Calling methods with different employee names
$object->calculate_wage("Sachin");
$object->calculate_wage("Satish");

?>