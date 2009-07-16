<?php
/**
 * @name 	Database class
 * @author 	Yorick Peterse
 * @link 	http://www.yorickpeterse.com
 *
 */

class Database {
	
	// Function to the database and tables and fill them with the default data
	function create_database($data)
	{
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],'');
		
		
		// Check for errors
		if(mysqli_connect_errno())
		{			
			return false;
		}

		// Create the prepared statement
		$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$data['database']);
		
		// Close the connection
		$mysqli->close();
	}
	
	// Function to create the tables and fill them with the default data
	function create_tables($data)
	{
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);
		
		// Check for errors
		if(mysqli_connect_errno())
		{	
			return false;
		}
		
		// Open the default SQL file
		$query 	 = file_get_contents('sql_files/1-tables.sql');
		$query 	.= file_get_contents('sql_files/2-default_data.sql');
		
		// Execute a multi query
		$mysqli->multi_query($query);
		
		// Close the connection
		$mysqli->close();
	}
	
	// Function to insert dummy data
	function dummy_data($data)
	{
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);
		
		// Check for errors
		if(mysqli_connect_errno())
		{
			return false;
		}
		
		// Open the default SQL file
		$query 	 = file_get_contents('sql_files/3-dummy_data-optional.sql');
		
		// Execute a multi query
		$mysqli->multi_query($query);
		
		// Close the connection
		$mysqli->close();
	}
}
?>