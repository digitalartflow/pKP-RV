<?php
    class DbList extends ArrayObject
    {

        function DbList( $sql )
        {
            //echo $sql;
            $q = mysql_query( $sql ) or die
            (
                '<div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em;"><p>'.
                "EROARE SQL: <br>". $sql ."<hr>". mysql_error()."<br/><br/>" .
                '</p></div>'
            );

            if( !is_bool( $q ) )
            {
                while( $line = mysql_fetch_array( $q ) )
                {
                    parent::append( $line );
                }
            }
        }

        /**
        * executa un query care nu intoarce un rezultat
        *
        * @param string $sql
        */
        static function ExecNoneQuery( $sql )
        {
            //echo $sql;
            $q = mysql_query( $sql ) or die
            (
                '<div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em;"><p>'.
                "EROARE SQL: <br>". $sql ."<hr>". mysql_error()."<br/><br/>" .
                '</p></div>'
            );
        }

        /**
        * wrapper pt functia de SELECT
        * $ret = DbList::SELECT( "*", "produse", "Id='19'" );
        *
        * @param string $what
        * @param string $from
        * @param string $where
        * @param string $group_by
        * @param string $order_by
        * @param string $limit
        */
        static function Select( $what, $from, $where = "", $group_by = "", $order_by = "", $limit = "" )
        {
            $sql  = "SELECT ".$what." FROM `".$from."` ";
            ( $where    != "" ) ? ( $sql .= " WHERE "   .$where    ) : ( $sql .= "" );
            ( $group_by != "" ) ? ( $sql .= " GROUP BY ".$group_by ) : ( $sql .= "" );
            ( $order_by != "" ) ? ( $sql .= " ORDER BY ".$order_by ) : ( $sql .= "" );
            ( $limit    != "" ) ? ( $sql .= " LIMIT "   .$limit    ) : ( $sql .= "" );
            return new DbList( $sql );
        }

        /**
        * wrapper pt functia de UPDATE
        * ex:
        * DbList::Update( "produse", array( "Nume" => "nume nou", "Pret" => "12" ), "Id='19'" );
        * sau
        * $vars["Nume"] = "nume nou";
        * $vars["Pret"] = "12";
        * DbList::Update( "produse", $vars, "Id='10'" );
        *
        * @param string $tables
        * @param array  $fields_and_vals
        * @param string $where
        */
        static function Update( $tables, $fields_and_vals, $where = "" )
        {
            $sql     = "UPDATE `".$tables."` SET ";
            $columns = array_keys($fields_and_vals);
            for( $i  = 0; $i < count( $columns); $i++ )
            {
                $key  = $columns[$i];
                $val  = $fields_and_vals[ $key ];
                $sql .= "`".$key."` = '". addslashes( $val ) ."', ";
            }
            //scoate ultimul spatiu si virgula
            $sql = substr( $sql, 0, strlen($sql) - 2 );
            ( $where    != "" ) ? ( $sql .= " WHERE "   .$where    ) : ( $sql .= "" );
            //echo $sql;
            DbList::ExecNoneQuery( $sql );
        }

        /**
        * wrapper pt functia de UPDATE
        * ex:
        * DbList::Delete( "produse", "Id='19'" );
        *
        * @param string $tables
        * @param array  $fields_and_vals
        * @param string $where
        */
        static function Delete( $tables, $where = "" )
        {
            $sql     = "DELETE FROM `".$tables."` ";
            ( $where    != "" ) ? ( $sql .= " WHERE "   .$where    ) : ( $sql .= "" );
            DbList::ExecNoneQuery( $sql );
        }

         /**
        * wrapper pt functia de INSERT INTO
        * ex:
        * DbList::Insert( "produse", array( "Nume"=>"produs nou", "Pret"=>"15") );
        * sau
        * $vars["Nume"] = "produs nou";
        * $vars["Pret"] = "12";
        * DbList::Insert( "produse", $vars );
        *
        * @param string $table
        * @param array  $values
        */
        static function Insert( $table, $values )
        {
            $sql     = "INSERT INTO `".$table."`(";
            $keys    = array_keys( $values );
            foreach( $keys as $key )
                $sql .=" `". $key ."`, ";
            //scoate ultimul spatiu si virgula
            $sql = substr( $sql, 0, strlen($sql) - 2 );
            //
            $sql.= ") VALUES (";
            foreach( $keys as $key )
                $sql .=" '". addslashes( $values[$key] ) ."', ";
            //scoate ultimul spatiu si virgula
            $sql = substr( $sql, 0, strlen($sql) - 2 );
            $sql.= ");";
            DbList::ExecNoneQuery( $sql );
        }

        /**
        * intoarce nr de randuri
        */
        function Size()
        {
            return count($this);
        }

    }
?>