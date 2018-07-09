<?php
    /*
    * base class for db objects
    * derive from this from now
    * version 2.0 alpha - by dan lutescu dan.lutescu@yahoo.com
    */
    class DbBase extends ArrayObject
    {

        function DbBase( $id = -1,$create_columns = true )
        {

            if( $create_columns )
            {
                //adauga cu valori goale toate coloanele tabelei respective
                $lst = new DbList( "SHOW COLUMNS FROM `".$this->getTableName()."`" );
                foreach( $lst as $line )
                    $this[ $line["Field"] ] = "";
            }
            if( $id != -1 ) $this->fromId($id);
			
        }

        function fromWhere( $column, $value )
        {
            $lst = DbList::Select("*", $this->getTableName(), "`".$column."`='".$value."'" );
            if( $lst->Size() > 0 )
            {
                $this->fromArray( $lst[0] );
                return true;
            }
            else
                return false;
        }
		
		function getEnumList( $table_name, $column )
		{
			$ret = array();
			$lst = new DbList("DESC `".$table_name."`");
			
			for( $i = 0; $i < $lst->Size(); $i++ )
			{
				if( $lst[$i][ "Field" ] == $column )
				{
					
					$val = $lst[$i][ "Type" ];
					$ret = Util::cauta( $val, "'", "'" );
					//iesi din bucla
					break;
				}
			}
			return $ret;
		}

        function getNextId()
        {
            $lst   = new DbList( "SHOW TABLE STATUS LIKE '" . $this->getTableName() . "'" );
            $ret   = $lst[0]["Auto_increment"];
            return $ret;
        }

        function fromId( $id )
        {
            $lst    = DbList::Select( "*", $this->getTableName(), "`".$this->getIdColumnName()."`='". $id ."'" );
            if( $lst->Size() > 0 )
                $this->fromArray( $lst[0] );
            else
                return -1; //daca nu gasesc obiecutl cu idul respectiv
        }
		
		function fromArray( $array, $exclude = array() )
        {
            $keys = array_keys( $array );
            foreach( $keys as $key )
			{
                if( !in_array($key,$exclude) && isset($this[$key]) ) $this[ $key ] = $array[ $key ];
			}
        }
 

        function fromPostArray()
        {
            $keys = array_keys( $_POST );
            foreach( $keys as $key )
			{
				if( Util::StartsWith( $key, "Db" ) && $key != "DbId" )
				{
					$db_column          = substr( $key, 2 );
					$this[ $db_column ] = $_POST[ $key ];
				}
			}
			return $this;
        }

        //OVERRIDE THIS!! -> returns the current db table name
        function getTableName()
        {
            return "";
        }

        //OVERRIDE THIS IF YOU WANT!! -> returns the current id column name
        function getIdColumnName()
        {
            return "Id";
        }

        //$type = GET sau POST
        function setFromForm( $type )
        {
            foreach ($this as $name => $value)
            {
                $val       = $_GET[ $name ];
                if( $type == "POST" ) $val = $_POST[ $name ];
                if( !empty( $val )  ) $this[ $name ] = $val ;
            }
        }

        function getId()
        {
            $ret = -1;
            
            if( array_key_exists( $this->getIdColumnName(), $this ) )
                $ret = $this[ $this->getIdColumnName() ];
            //
            return $ret;
        }

        function Update()
        {
            DbList::Update
            (
                $this->getTableName(),
                $this->ToArray(),
                "`".$this->getIdColumnName()."`='".$this[ $this->getIdColumnName() ]."'"
            );
        }

        function CreateNew()
        {
            DbList::Insert( $this->getTableName(), $this->ToArray() );
        }

        function Delete()
        {
            DbList::Delete( $this->getTableName(), "`".$this->getIdColumnName()."`='".$this->getId()."'" );
        }

        function ToArray()
        {
            $ret  = array();
            $keys = array_keys( parent::getArrayCopy() );
            foreach( $keys as $key )
                if( !is_numeric($key) ) $ret[ $key ]  = $this[ $key ] ;
            return $ret;
        }
    }
?>