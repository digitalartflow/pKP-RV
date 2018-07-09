<?php
    class DbRoomDoor extends DbBase
    {
        function getTableName()
        {
            return "room_doors";
        }
		
		function Delete()
		{
			$list = new DbList('select Id from room_doors_pics where IdDoor = "'.$this['Id'].'"');
			foreach( $list as $dbPic )
			{
				$item = new DbRoomDoorPic( $dbPic['Id'] );
				$item->Delete();
			}
			parent::Delete();
		}
    }
    class DbRoomDoorPic extends DbBase
    {
        function getTableName()
        {
            return "room_doors_pics";
        }
		
		function Delete()
		{
			global $config;
			if( is_file( $config['server_path'].'uploads/door_variation/'.$this['Picture'] ) ) unlink($config['server_path'].'uploads/door_variation/'.$this['Picture']);
			if( is_file( $config['server_path'].'uploads/door_variation/'.$this['Render0'] ) ) unlink($config['server_path'].'uploads/door_variation/'.$this['Render0']);
			if( is_file( $config['server_path'].'uploads/door_variation/'.$this['Render90'] ) ) unlink($config['server_path'].'uploads/door_variation/'.$this['Render90']);
			if( is_file( $config['server_path'].'uploads/door_variation/'.$this['Render180'] ) ) unlink($config['server_path'].'uploads/door_variation/'.$this['Render180']);
			if( is_file( $config['server_path'].'uploads/door_variation/'.$this['Render270'] ) ) unlink($config['server_path'].'uploads/door_variation/'.$this['Render270']);
			parent::Delete();
		}
    }
    class DbRoomWindow extends DbBase
    {
        function getTableName()
        {
            return "room_windows";
        }
		
		function Delete()
		{
			$list = new DbList('select Id from room_windows_pics where IdWindow = "'.$this['Id'].'"');
			foreach( $list as $dbPic )
			{
				$item = new DbRoomWindowPic( $dbPic['Id'] );
				$item->Delete();
			}
			parent::Delete();
		}
    }
    class DbRoomWindowType extends DbBase
    {
        function getTableName()
        {
            return "room_window_types";
        }
    }
    class DbRoomWindowPic extends DbBase
    {
        function getTableName()
        {
            return "room_windows_pics";
        }
		
		function Delete()
		{
			global $config;
			if( is_file( $config['server_path'].'uploads/window_variation/'.$this['Picture'] ) ) unlink($config['server_path'].'uploads/window_variation/'.$this['Picture']);
			if( is_file( $config['server_path'].'uploads/window_variation/'.$this['Render0'] ) ) unlink($config['server_path'].'uploads/window_variation/'.$this['Render0']);
			if( is_file( $config['server_path'].'uploads/window_variation/'.$this['Render90'] ) ) unlink($config['server_path'].'uploads/window_variation/'.$this['Render90']);
			if( is_file( $config['server_path'].'uploads/window_variation/'.$this['Render180'] ) ) unlink($config['server_path'].'uploads/window_variation/'.$this['Render180']);
			if( is_file( $config['server_path'].'uploads/window_variation/'.$this['Render270'] ) ) unlink($config['server_path'].'uploads/window_variation/'.$this['Render270']);
			parent::Delete();
		}
    }
    class DbManufacturer extends DbBase
    {
        function getTableName()
        {
            return "manufacturers";
        }
		
		function Delete()
		{
			global $config;
			if( is_file( $config['server_path'].'uploads/manufacturers/'.$this['Logo'] ) ) unlink($config['server_path'].'uploads/manufacturers/'.$this['Logo']);
			parent::Delete();
		}
    }
    class DbTopTexture extends DbBase
    {
        function getTableName()
        {
            return "tops";
        }
		
		function Delete()
		{
			global $config;
			if( is_file( $config['server_path'].'uploads/top_textures/'.$this['Picture'] ) ) unlink($config['server_path'].'uploads/top_textures/'.$this['Picture']);
			parent::Delete();
		}
    }
    class DbTexture extends DbBase
    {
        function getTableName()
        {
            return "textures";
        }
		
		function Delete()
		{
			global $config;
			if( is_file( $config['server_path'].'uploads/textures/'.$this['Picture'] ) ) unlink($config['server_path'].'uploads/textures/'.$this['Picture']);
			parent::Delete();
		}
    }
    class DbCarcasse extends DbBase
    {
        function getTableName()
        {
            return "carcasses";
        }
		
		function Delete()
		{
			global $config;
			if( is_file( $config['server_path'].'uploads/carcasses/'.$this['Picture'] ) ) unlink($config['server_path'].'uploads/carcasses/'.$this['Picture']);
			parent::Delete();
		}
    }
    class DbHandle extends DbBase
    {
        function getTableName()
        {
            return "latches";
        }
		
		function Delete()
		{
			global $config;
			if( is_file( $config['server_path'].'uploads/latches/'.$this['Picture'] ) ) unlink($config['server_path'].'uploads/latches/'.$this['Picture']);
			parent::Delete();
		}
    }
    class DbDoor extends DbBase
    {
        function getTableName()
        {
            return "unit_doors";
        }
		
		function Delete()
		{
			global $config;
			if( is_file( $config['server_path'].'uploads/unit_doors/'.$this['Picture'] ) ) unlink($config['server_path'].'uploads/unit_doors/'.$this['Picture']);
			parent::Delete();
		}
    }
    class DbHtmlPage extends DbBase
    {
        function getTableName()
        {
            return "html_pages";
        }
		
		function Delete()
		{
			global $config;
			if( is_file( $config['server_path'].'html_pages/'.$this['Link'] ) ) unlink($config['server_path'].'html_pages/'.$this['Link']);
			parent::Delete();
		}
    }
    class DbUnit extends DbBase
    {
        function getTableName()
        {
            return "units";
        }
		
		function Delete()
		{
			global $config;
			if( is_file($config['server_path'].'uploads/swf_2d/'.$this['Swf2D']) ) unlink($config['server_path'].'uploads/swf_2d/'.$this['Swf2D']);
		
			$items = new DbList('select Id from units_handles where IdUnit="'.$this['Id'].'"');
			foreach( $items as $item ){
				$item = new DbUnitHandle($item['Id']);
				$item->Delete();
			}
			
			$tops = new DbList('select Id from units_tops where IdUnit="'.$this['Id'].'"');
			foreach( $items as $item ){
				$item = new DbUnitTop($item['Id']);
				$item->Delete();
			}
			
			$variations = new DbList('select Id from unit_variations where IdUnit="'.$this['Id'].'"');
			foreach( $items as $item ){
				$item = new DbUnitVariation($item['Id']);
				$item->Delete();
			}
			
			parent::Delete();
		}
    }
    class DbUnitCategory extends DbBase
    {
        function getTableName()
        {
            return "units_categories";
        }
		
		function Delete()
		{
			global $config;
			parent::Delete();
		}
    }
    class DbUnitHandle extends DbBase
    {
        function getTableName()
        {
            return "units_handles";
        }
		
		function Delete()
		{
			global $config;
			if( is_file( $config['server_path'].'uploads/unit_handles/'.$this['Image0'] ) ) unlink($config['server_path'].'uploads/unit_handles/'.$this['Image0']);
			if( is_file( $config['server_path'].'uploads/unit_handles/'.$this['Image90'] ) ) unlink($config['server_path'].'uploads/unit_handles/'.$this['Image90']);
			if( is_file( $config['server_path'].'uploads/unit_handles/'.$this['Image180'] ) ) unlink($config['server_path'].'uploads/unit_handles/'.$this['Image180']);
			if( is_file( $config['server_path'].'uploads/unit_handles/'.$this['Image270'] ) ) unlink($config['server_path'].'uploads/unit_handles/'.$this['Image270']);
			parent::Delete();
		}
    }
    class DbUnitTop extends DbBase
    {
        function getTableName()
        {
            return "units_tops";
        }
		
		function Delete()
		{
			global $config;
			if( is_file( $config['server_path'].'uploads/unit_tops/'.$this['Image0'] ) ) unlink($config['server_path'].'uploads/unit_tops/'.$this['Image0']);
			if( is_file( $config['server_path'].'uploads/unit_tops/'.$this['Image90'] ) ) unlink($config['server_path'].'uploads/unit_tops/'.$this['Image90']);
			if( is_file( $config['server_path'].'uploads/unit_tops/'.$this['Image180'] ) ) unlink($config['server_path'].'uploads/unit_tops/'.$this['Image180']);
			if( is_file( $config['server_path'].'uploads/unit_tops/'.$this['Image270'] ) ) unlink($config['server_path'].'uploads/unit_tops/'.$this['Image270']);
			parent::Delete();
		}
    }
    class DbUnitVariation extends DbBase
    {
        function getTableName()
        {
            return "unit_variations";
        }
		
		function Delete()
		{
			global $config;
			if( is_file( $config['server_path'].'uploads/unit_variations/'.$this['Image0'] ) ) unlink($config['server_path'].'uploads/unit_variations/'.$this['Image0']);
			if( is_file( $config['server_path'].'uploads/unit_variations/'.$this['Image90'] ) ) unlink($config['server_path'].'uploads/unit_variations/'.$this['Image90']);
			if( is_file( $config['server_path'].'uploads/unit_variations/'.$this['Image180'] ) ) unlink($config['server_path'].'uploads/unit_variations/'.$this['Image180']);
			if( is_file( $config['server_path'].'uploads/unit_variations/'.$this['Image270'] ) ) unlink($config['server_path'].'uploads/unit_variations/'.$this['Image270']);
			parent::Delete();
		}
    }
    class DbState extends DbBase
    {
        function getTableName()
        {
            return "states";
        }
    }
    class DbStateRegion extends DbBase
    {
        function getTableName()
        {
            return "states_regions";
        }
    }
    class DbPredefinedStyle extends DbBase
    {
        function getTableName()
        {
            return "predefined_styles";
        }
		
		function Delete()
		{
			global $config;
			if( is_file( $config['server_path'].'uploads/predefined_styles/original/'.$this['pic'] ) ) unlink($config['server_path'].'uploads/predefined_styles/original/'.$this['pic']);
			if( is_file( $config['server_path'].'uploads/predefined_styles/small/'.$this['pic'] ) ) unlink($config['server_path'].'uploads/predefined_styles/small/'.$this['pic']);
			parent::Delete();
		}
    }
    class DbPsMadeMaterial extends DbBase
    {
        function getTableName()
        {
            return "ps_made_material";
        }
    }
    class DbPsStyle extends DbBase
    {
        function getTableName()
        {
            return "ps_style";
        }
    }
?>