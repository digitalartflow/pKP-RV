<?php
	class DbList
	{
		var $colectie = array();
		
		function DbList( $sql )
		{
			$q = mysql_query( $sql ) or die ( "<hr>EROARE SQL: <br>". ParsMysql($sql) ."<hr>". mysql_error()."<hr>" );
			if( !is_bool( $q ) ) while( $line = mysql_fetch_array( $q ) ) array_push( $this->colectie, $line );	
		}
		
		function ExecuteQuery( $sql )
		{
			$q = mysql_query( $sql ) or die ( "<hr>EROARE SQL: <br>". ParsMysql($sql) ."<hr>". mysql_error()."<hr>" );
		}
		
		function ExecuteSQL( $sql )
		{
			DbList::ExecuteQuery( $sql );
		}
		
		function Size()
		{
			return count($this->colectie);
		}
		
		function Get($index)
		{
			return $this->colectie[$index];
		}	
		
		function GetValue( $row_index, $column_name )
		{
			$line = $this->Get( $row_index );
			return $line[ $column_name ];
		}
		

		
		function GetCollection()
		{
			return $this->colectie;
		}
		
		function GetNonNumericCollection()
		{
			$ret = array();
			$i   = 0;
			foreach( $this->colectie as $line )
			{
				$ret["line".$i] = $line;
				$i++;
			}
			return $ret;
		}
		
		function FilterOneRow( $column_name, $value )
		{
			$ret    = -1;
			for( $i = 0; $i < count( $this->colectie ); $i++ )
			{
				$row      = $this->colectie[$i];
				$val      = $row[$column_name];
				if( $val == $value )
				{
					$ret = $row;
					break;
				}
			}
			return $ret;
		}
		
		function Filter( $column_name, $value )
		{
			$ret = array();
			for( $i = 0; $i < count( $colectie ); $i++ )
			{
				$row      = $colectie[$i][ $column_name ];
				if( $row == $value ) array_push( $ret, $row ); 
			}
			return $ret;
		}
		
	}
?>