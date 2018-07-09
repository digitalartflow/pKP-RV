<?php
	/*
	* base class for db objects
	* derive from this from now
	* version 2.0 alpha - by dan lutescu dan.lutescu@yahoo.com
	*/
	class DbBase{
	
		var $BaseArray;
		
		function DbBase( $create_columns = true )
		{
			$sql = "SHOW COLUMNS FROM ".$this->getTableName();
			$q   = mysql_query(  $sql ) or die("EROARE:<hr>".$sql."<hr>".mysql_error(  ) );
			while( $line = mysql_fetch_array( $q ) )
			{
				$this->BaseArray[ $line["Field"] ] = "";
				$line["Field"]."<br>";
			}
		}
		
		function get( $column ) { return $this->BaseArray[ $column ]; }
		
		function set( $column, $value ) { $this->BaseArray[ $column ] = $value; }
		
		function fromWhere($column,$value)
		{
			
			$sql = "SELECT * FROM `".$this->getTableName()."`";
			$sql.=" WHERE ".$column."='".$value."'";
			$q   = mysql_query(   $sql ) or die("EROARE SQL: <hr>".$sql."<hr>EROARE:".mysql_error(  ));
			if( mysql_num_rows( $q ) > 0 )
			{
				$line= mysql_fetch_array( $q );
				$this->fromArray( $line );
				return true;
			}
			else
			{
				return false;
			}
		}
		
		function getNextId()
		{
			
			$sql   = "SHOW TABLE STATUS LIKE '" . $this->getTableName() . "'";
			$q     = mysql_query(   $sql ) or die("EROARE SQL: <hr>".$sql."<hr>EROARE:".mysql_error(  ));
			$line  = mysql_fetch_array( $q );
			$ret   = $line["Auto_increment"];
			return $ret;
		}
		
		function fromId( $id )
		{
			
			$sql = "SELECT * FROM `".$this->getTableName()."`";
			if($id != -1 ) $sql.=" WHERE Id=".$id;
			$q   = mysql_query(   $sql ) or die("EROARE SQL: <hr>".$sql."<hr>EROARE:".mysql_error(  ));
			if( mysql_num_rows( $q ) > 0 ){
				$line= mysql_fetch_array( $q );
				$this->fromArray( $line );
			} else {
				return -1;
			}
		}
	
		function fromArray( $array ) { $this->BaseArray = $array; }
		
		//OVERRIDE THIS!! -> returns the current db table name
		function getTableName() { return ""; }	
		
		function setFromArray( $val, $exclude = array() )
		{
			foreach ($this->BaseArray as $name => $value) 
			{
				if( !empty( $val ) && isset( $val[$name] ) && !in_array($name,$exclude) ) $this->set( $name, $val[$name] );
			}
		}			
		
		function getId(){
			$ret = -1;
			foreach ($this->BaseArray as $name => $value) 
			{
				if( $name == "Id" ) 
				{
					$ret = $value;
					break;
				}
			}
			return $ret;
		}
		
		function Update( $theid = "Id")
		{
			
			$sql = "UPDATE `".$this->getTableName()."` SET ";
			$id = -1;
			foreach ($this->BaseArray as $name => $value) 
			{
				if( !is_numeric($name) )
				{
					$sql .= "`".$name."`='".addslashes($value)."', ";
					if( $name == $theid ) $id = $value;
				}
			}
			$sql = substr($sql, 0, strlen($sql) -2 );
			if( $id != -1 ) $sql.= " WHERE ".$theid."=".$id;
			mysql_query(   $sql ) or die("<hr>"."EROARE SQL: ". $sql."<br>".mysql_error(  ));
		}
		
		function CreateNew( $insertId = false )
		{
			
			$sql = "INSERT INTO `".$this->getTableName()."`(";
			//add columns
			foreach ($this->BaseArray as $name => $value) 
			{
				if( !is_numeric($name) )
				{
					if( $name != "Id" || ( $name == "Id" && $insertId ) )	
						$sql .= "`".$name."`,";
				}
			}
			$sql = substr($sql, 0, strlen($sql) - 1 );
			//add values
			$sql .= ") values (";
			foreach ($this->BaseArray as $name => $value) 
			{
				if( !is_numeric($name) )
				{
					if( $name != "Id" || ( $name == "Id" && $insertId ) )	
						$sql .= "'".addslashes($value)."',";
				}
			}
			$sql  = substr($sql, 0, strlen($sql) - 1 );
			$sql .= ")";
			mysql_query(   $sql ) or 
				die("<hr>"."EROARE SQL: ". $sql."<br>".mysql_error(  ));
		}
		//overide this function when neded
		function Delete()
		{
			$sql = "DELETE FROM `".$this->getTableName()."` ";
			$sql.= "WHERE Id=".$this->getId();
			mysql_query(   $sql ) or 
				die("<hr>"."EROARE SQL: ". $sql."<br>".mysql_error(  ));
		}
	}
?>