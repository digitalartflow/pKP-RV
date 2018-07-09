<?php
	
	class DbOrder extends DbBase
	{
		function getTableName()
		{
			return 'orders';
		}
	}
	
	class DbSavedRoomDesign extends DbBase
	{
		function getTableName()
		{
			return 'room_designs';
		}
	}
	
	class DbUser extends DbBase
	{
		function getTableName()
		{
			return 'users';
		}
	}
	
	class DbRoomDoorType extends DbBase
	{
		function getTableName()
		{
			return 'room_doors_types';
		}
	}
	
	class DbRoomDoor extends DbBase
	{
		function getTableName()
		{
			return 'room_doors';
		}
	}
	
	class DbRoomDoorVariation extends DbBase
	{
		function getTableName()
		{
			return 'room_doors_pics';
		}
		function Delete()
		{
			//delete picture
			if( is_file(PROGRAM_PATH.'uploads/door_variation/'.$this->get('Picture')) ) unlink(PROGRAM_PATH.'uploads/door_variation/'.$this->get('Picture'));
			$sql = "DELETE FROM `".$this->getTableName()."` ";
			$sql.= "WHERE Id=".$this->getId();
			mysql_query(   $sql ) or 
				die("<hr>"."EROARE SQL: ". $sql."<br>".mysql_error(  ));
		}
	}
	
	class DbRoomWindowType extends DbBase
	{
		function getTableName()
		{
			return 'room_window_types';
		}
	}
	
	class DbRoomWindow extends DbBase
	{
		function getTableName()
		{
			return 'room_windows';
		}
	}
	
	class DbRoomWindowVariation extends DbBase
	{
		function getTableName()
		{
			return 'room_windows_pics';
		}
		function Delete()
		{
			//delete picture
			if( is_file(PROGRAM_PATH.'uploads/window_variation/'.$this->get('Picture')) ) unlink(PROGRAM_PATH.'uploads/window_variation/'.$this->get('Picture'));
			$sql = "DELETE FROM `".$this->getTableName()."` ";
			$sql.= "WHERE Id=".$this->getId();
			mysql_query(   $sql ) or 
				die("<hr>"."EROARE SQL: ". $sql."<br>".mysql_error(  ));
		}
	}
	
	class DbUnitCategory extends DbBase
	{
		function getTableName()
		{
			return 'units_categories';
		}
		function Delete()
		{
			DbList::ExecuteSQL('delete from units_categories where IdParent="'.$this->getId().'"');
			$sql = "DELETE FROM `".$this->getTableName()."` ";
			$sql.= "WHERE Id=".$this->getId();
			mysql_query(   $sql ) or 
				die("<hr>"."EROARE SQL: ". $sql."<br>".mysql_error(  ));
		}
	}
	
	class DbUnit extends DbBase
	{
		function getTableName()
		{
			return 'units';
		}
	}
	
		
?>
