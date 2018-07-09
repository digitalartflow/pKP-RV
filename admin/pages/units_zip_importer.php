<?php
	$core['template'] = "units_zip_importer.tpl";
	
	$file_scan = scandir($config['server_path'].'admin/tmp/unzip/');
	$dirs = array();
	foreach( $file_scan as $file  ){
		if( strlen($file) > 3 ){
			$dirs[] = $file;
		}
	}
	$smarty->assign('dirs',$dirs);
	
	/*exec('unzip tmp/units1.zip -d tmp/unzip/units2',$out);	
	
	echo "<pre>";
	print_r($out);
	die();*/
	
	//exec('rm -rf tmp/tozip/units',$out);
	//die();
	
	if( isset( $_GET['download_zip'] ) ){
		$units = new DbList('select Id, Name from units ');
		$base_folder = $config['server_path'].'/admin/tmp/tozip/units';
		@mkdir($base_folder);
		$handles = new DbList('select * from latches');
		$worktops = new DbList('select * from tops');
		$unit_doors = new DbList('select * from unit_doors');
		$textures = new DbList('select * from textures');
		$carcasses = new DbList('select * from carcasses');
		foreach( $units as $unit ){
			$parent_folder = $base_folder.'/'.$unit['Name'];
			@mkdir($parent_folder);
			$handles_folder = $parent_folder.'/handles';
			@mkdir($handles_folder);
			foreach( $handles as $handle ){
				@mkdir($handles_folder.'/'.$handle['Name']);
			}
			$worktops_folder = $parent_folder.'/worktops';
			@mkdir($worktops_folder);
			foreach( $worktops as $worktop ){
				@mkdir($worktops_folder.'/'.$worktop['Name']);
			}
			$variations_folder = $parent_folder.'/variations';
			@mkdir($variations_folder);
			foreach( $unit_doors as $unit_door ){
				foreach( $textures as $texture ){
					foreach( $carcasses as $carcass ){
						@mkdir($variations_folder.'/'.$unit_door['Name'].'~'.$texture['Name'].'~'.$carcass['Name']);
					}
				}
			}
		}
		chdir('tmp/tozip');
		exec('zip -r units units/*',$out);
		header("Content-length:".filesize('units.zip'));
		header('Content-Type: application/zip'); // ZIP file
		header('Content-Disposition: attachment; filename="units.zip"');
		header('Content-Transfer-Encoding: binary');
		readfile('units.zip');
		exec('rm -rf units',$out);
		unlink('units.zip');
		die();
	}
	
	if( isset( $_GET['download_db_zip'] ) ){
		$units = new DbList('select Id, Name from units ');
		$base_folder = $config['server_path'].'/admin/tmp/tozip/units';
		@mkdir($base_folder);
		$handles = new DbList('select * from latches');
		$worktops = new DbList('select * from tops');
		$unit_doors = new DbList('select * from unit_doors');
		$textures = new DbList('select * from textures');
		$carcasses = new DbList('select * from carcasses');
		foreach( $units as $unit ){
			$parent_folder = $base_folder.'/'.$unit['Name'];
			@mkdir($parent_folder);
			$handles_folder = $parent_folder.'/handles';
			@mkdir($handles_folder);
			$unit_handles = new DbList('select IdHandle from units_handles where IdUnit="'.$unit['Id'].'"');
			foreach( $handles as $handle ){
				foreach($unit_handles as $unit_handle ){
					if( $unit_handle['IdHandle'] == $handle['Id'] ){
						@mkdir($handles_folder.'/'.$handle['Name']);
						continue;
					}
				}
			}
			$worktops_folder = $parent_folder.'/worktops';
			@mkdir($worktops_folder);
			$unit_worktops = new DbList('select IdTop from units_tops where IdUnit="'.$unit['Id'].'"');
			foreach( $worktops as $worktop ){
				foreach($unit_worktops as $unit_worktop ){
					if( $unit_worktop['IdTop'] == $worktop['Id'] ){
						@mkdir($worktops_folder.'/'.$worktop['Name']);
						continue;
					}
				}
			}
			$variations_folder = $parent_folder.'/variations';
			@mkdir($variations_folder);
			$unit_variations = new DbList('select IdDoor,IdTexture,IdCarcass from unit_variations where IdUnit="'.$unit['Id'].'"');
			foreach( $unit_doors as $unit_door ){
				foreach( $textures as $texture ){
					foreach( $carcasses as $carcass ){
						foreach($unit_variations as $unit_variation ){
							if( $unit_variation['IdDoor'] == $unit_door['Id'] && $unit_variation['IdTexture'] == $texture['Id'] && $unit_variation['IdCarcass'] == $carcass['Id'] ){
								@mkdir($variations_folder.'/'.$unit_door['Name'].'~'.$texture['Name'].'~'.$carcass['Name']);
								continue;
							}
						}
					}
				}
			}
		}
		chdir('tmp/tozip');
		exec('zip -r units_existing units/*',$out);
		/*header("Content-length:".filesize($config['server_path'].'/admin/tmp/tozip/units_existing.zip'));
		header('Content-Type: application/zip'); // ZIP file
		header('Content-Disposition: attachment; filename="units_existing.zip"');
		header('Content-Transfer-Encoding: binary');
		*/
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-type: application/zip");
		header("Content-Disposition: attachment; filename=\"units_existing.zip\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($config['server_path'].'/admin/tmp/tozip/units_existing.zip'));
		
		readfile('units_existing.zip');
		exec('rm -rf units',$out);
		unlink('units_existing.zip');
		die();
	}
	
	if( !empty( $_GET['delete_folder'] ) ){
		if( is_dir( $config['server_path'].'admin/tmp/unzip/'.$_GET['delete_folder'].'/units' ) && $_GET['delete_folder'] != 'units1' )
			exec('rm -rf tmp/unzip/'.$_GET['delete_folder'],$out);
		Util::Redirect($config['admin_url'].'?page='.$_GET['page']);
		die();
	}
	if( !empty( $_GET['scan_folder'] ) && is_dir( $config['server_path'].'admin/tmp/unzip/'.$_GET['scan_folder'].'/units' ) ){
	
		$units_dir = $config['server_path'].'admin/tmp/unzip/'.$_GET['scan_folder'].'/units';
		//$units_dir_od = opendir($units_dir);
		$units = array();
		$file_scan = scandir($units_dir);
		foreach( $file_scan as $file  ){
			if( strlen($file) > 3 ){
				
				$unit = array( 'name' => $file,'handles'=>array(),'worktops'=>array(),'variations'=>array());
				$found = new DbList('select * from units where `Name`="'.$file.'"');
				$unit['found'] = $found;
				//handles
				$handle_dir = $units_dir.'/'.$file.'/handles';
				//$handie_dir_od = opendir($handle_dir);
				$handler_scan = scandir($handle_dir);
				foreach( $handler_scan as $handler ){
					if( strlen($handler) > 3 ){
						$handle = array( 'name' => $handler,'pics'=>array());					
						$found = new DbList('select * from latches where `Name`="'.$handler.'"');
						$handle['found'] = $found;
						$handle_pics_dir = $handle_dir.'/'.$handler.'/';
						//$handie_pics_dir_od = opendir($handle_pics_dir);
						$handle_pic_scan = scandir($handle_pics_dir);
						if( count( $handle_pic_scan ) == 6 ){
							foreach( $handle_pic_scan as $handle_pic ){
								if( strlen($handle_pic) > 3 ){
									$handle['pics'][] = str_replace($config['server_path'],$config['siteurl'],$handle_pics_dir).$handle_pic;
								}
							}
							$unit['handles'][] = $handle;
						}
					}
				}
				//worktops
				$worktops_dir = $units_dir.'/'.$file.'/worktops';
				//$worktops_dir_od = opendir($worktops_dir);
				$worktopr_scan = scandir($worktops_dir);
				foreach( $worktopr_scan as $worktopr ){
					if( strlen($worktopr) > 3 ){
						$worktop = array( 'name' => $worktopr,'pics'=>array());					
						$found = new DbList('select * from tops where `Name`="'.$worktopr.'"');
						$worktop['found'] = $found;
						$worktop_pics_dir = $worktops_dir.'/'.$worktopr.'/';
						//$worktop_pics_dir_od = opendir($worktop_pics_dir);
						$worktop_pic_scan = scandir($worktop_pics_dir);
						if( count( $worktop_pic_scan ) == 6 ){
							foreach( $worktop_pic_scan as $worktop_pic ){
								if( strlen($worktop_pic) > 3 ){
									$worktop['pics'][] = str_replace($config['server_path'],$config['siteurl'],$worktop_pics_dir).$worktop_pic;
								}
							}
							$unit['worktops'][] = $worktop;
						}
					}
				}
				//variations
				$variations_dir = $units_dir.'/'.$file.'/variations';
				//$variations_dir_od = opendir($variations_dir);
				$variationsr_scan = scandir($variations_dir);
				foreach( $variationsr_scan as $variationsr ){
					if( strlen($variationsr) > 3 ){
						$variation_pieces = explode('~',$variationsr);
						$variation = array( 'door'=>$variation_pieces[0],'range'=>$variation_pieces[1],'carcass'=>$variation_pieces[2],'pics'=>array());			
						$found = new DbList('select * from unit_doors where `Name`="'.$variation['door'].'"');
						$variation['door_found'] = $found;
						$found = new DbList('select * from textures where `Name`="'.$variation['range'].'"');
						$variation['range_found'] = $found;
						$found = new DbList('select * from carcasses where `Name`="'.$variation['carcass'].'"');
						$variation['carcass_found'] = $found;
						if( count( $variation_pieces ) >= 4 )
							$variation['product_code'] = $variation_pieces[3];
						$variation_pics_dir = $variations_dir.'/'.$variationsr.'/';
						//$variation_pics_dir_od = opendir($variation_pics_dir);
						$variation_pic_scan = scandir($variation_pics_dir);
						if( count( $variation_pic_scan ) == 6 ){
							foreach( $variation_pic_scan as $variation_pic ){
								if( strlen($variation_pic) > 3 ){
									$variation['pics'][] = str_replace($config['server_path'],$config['siteurl'],$variation_pics_dir).$variation_pic;
								}
							}
							$unit['variations'][] = $variation;
						}
					}
				}
				$units[] = $unit;
			}
		}
		/*echo "<pre>";
		print_r($units);
		die();*/
		$smarty->assign('units',$units);
	}
	
	if( !empty( $_FILES['file'] ) ){
		$filename = strtotime('now').'.zip';
		if( move_uploaded_file($_FILES['file']['tmp_name'],'tmp/'.$filename) ){
			exec('unzip tmp/'.$filename.' -d tmp/unzip/'.substr($_FILES['file']['name'],0,strlen($_FILES['file']['name'])-4).'-'.date('Y-m-d_H_i_s'));
			unlink('tmp/'.$filename);
		}
		Util::Redirect($config['admin_url'].'?page='.$_GET['page']);
		die();
	}
	$debug = false;
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'import' ){		
		if( $debug ){
			echo "<pre>";
			//print_r($_POST);
		}
		$unit_found_id = 0;
		foreach( $_POST as $key => $val ){
			if( $key == 'action' ) continue;
			$key_a = explode('_',$key);		
			if( $debug ){
				//print_r($key_a);
			}
			$unit = $units[$key_a[1]];
			$unit_found_id = isset( $unit['found'][0] ) ? $unit['found'][0]['Id'] : $unit_found_id;
			$unit_nr = $key_a[1];
			if( $key_a[0] == 'name' && !empty( $_POST['name_'.$unit_nr] ) ){
				$new_unit = new DbUnit();
				$unit_found_id = $new_unit -> getNextId();
				$new_unit['Name'] = $_POST['name_'.$unit_nr];
				$new_unit['IdManufacturer'] = 1;
				$new_unit['Categories'] = !empty($_POST['categories_'.$unit_nr]) ? '{'.implode('}{',$_POST['categories_'.$unit_nr]).'}' : '';
				$new_unit['Width'] = $_POST['width_'.$unit_nr];
				$new_unit['Height'] = $_POST['height_'.$unit_nr];
				$new_unit['Depth'] = $_POST['depth_'.$unit_nr];
				$new_unit['DistFromBottom'] = $_POST['dfb_'.$unit_nr];
				$new_unit['IsFloating'] = !empty( $_POST['dfb_'.$unit_nr] ) ? 1 : 0;
				$new_unit['HasWorktop'] = $_POST['worktop_'.$unit_nr];
				$new_unit['HasAppliance'] = $_POST['appliance_'.$unit_nr];
				$new_unit['Regions'] = '';
				$new_unit['DateCreated'] = date('Y-m-d H:i:s');
				$from_swf = $config['server_path'].'/admin/swfs/'.$_POST['swf_'.$unit_nr];
				$new_unit['Swf2D'] = $swf = createNewName($config['server_path'].'uploads/swf_2d/',substr($_POST['swf_'.$unit_nr],0,strlen($_POST['swf_'.$unit_nr])-4)).'.swf';
				
				if( $debug ){
					echo "--------------------------<br />";
					print_r($new_unit);
					echo "--------------------------<br />";
				}else{
					copy($from_swf,$config['server_path'].'uploads/swf_2d/'.$new_unit['Swf2D']);	
					$new_unit->CreateNew();
				}
			}
			if( strpos($key,'_handle_') !== false ){
				//continue;
				$handle = $unit['handles'][$key_a[3]];
				$handle_found = $handle['found'][0];
				//check if exists
				$handle_exists = new DbList('select * from units_handles where IdUnit="'.$unit_found_id.'" and IdHandle="'.$handle_found['Id'].'" order by Id ASC limit 1');
				$handle_id = -1;
				if( count( $handle_exists ) > 0 && !$debug ){
					$handle_id = $handle_exists[0]['Id'];
					if( is_file($config['server_path'].'uploads/unit_handles/'.$handle_exists[0]['Image0']) )
						unlink($config['server_path'].'uploads/unit_handles/'.$handle_exists[0]['Image0']);
					if( is_file($config['server_path'].'uploads/unit_handles/'.$handle_exists[0]['Image90']) )
						unlink($config['server_path'].'uploads/unit_handles/'.$handle_exists[0]['Image90']);
					if( is_file($config['server_path'].'uploads/unit_handles/'.$handle_exists[0]['Image180']) )
						unlink($config['server_path'].'uploads/unit_handles/'.$handle_exists[0]['Image180']);
					if( is_file($config['server_path'].'uploads/unit_handles/'.$handle_exists[0]['Image270']) )
						unlink($config['server_path'].'uploads/unit_handles/'.$handle_exists[0]['Image270']);
				}
				$item = new DbUnitHandle($handle_id);
				$item['IdUnit'] = $unit_found_id;
				$item['IdHandle'] = $handle_found['Id'];
				//$pic_0 = $handle['pics'][0];
				$pic_0 = createNewName($config['server_path'].'uploads/unit_handles/','0');
				$pic_1 = createNewName($config['server_path'].'uploads/unit_handles/','1');
				$pic_2 = createNewName($config['server_path'].'uploads/unit_handles/','2');
				$pic_3 = createNewName($config['server_path'].'uploads/unit_handles/','3');
				if( !$debug ){
					copy(str_replace($config['siteurl'],$config['server_path'],$handle['pics'][0]),$config['server_path'].'uploads/unit_handles/'.$pic_0.'.png');
					copy(str_replace($config['siteurl'],$config['server_path'],$handle['pics'][1]),$config['server_path'].'uploads/unit_handles/'.$pic_1.'.png');
					copy(str_replace($config['siteurl'],$config['server_path'],$handle['pics'][2]),$config['server_path'].'uploads/unit_handles/'.$pic_2.'.png');
					copy(str_replace($config['siteurl'],$config['server_path'],$handle['pics'][3]),$config['server_path'].'uploads/unit_handles/'.$pic_3.'.png');
				}
				$item['Image0'] = $pic_0.'.png';
				$item['Image90'] = $pic_1.'.png';
				$item['Image180'] = $pic_2.'.png';
				$item['Image270'] = $pic_3.'.png';
				if( $debug ) print_r($item);
				elseif( $handle_id > 0 )
					$item->Update();
				else
					$item->CreateNew();
				//print_r($item);
			}
			if( strpos($key,'_worktop_') !== false ){
				//continue;
				$handle = $unit['worktops'][$key_a[3]];
				$handle_found = $handle['found'][0];
				//check if exists
				$worktop_exists = new DbList('select * from  units_tops where IdUnit="'.$unit_found_id.'" and IdTop="'.$handle_found['Id'].'" order by Id ASC limit 1');
				$worktop_id = -1;
				if( count( $worktop_exists ) > 0 && !$debug ){
					$worktop_id = $worktop_exists[0]['Id'];
					if( is_file($config['server_path'].'uploads/unit_tops/'.$worktop_exists[0]['Image0']) )
						unlink($config['server_path'].'uploads/unit_tops/'.$worktop_exists[0]['Image0']);
					if( is_file($config['server_path'].'uploads/unit_tops/'.$worktop_exists[0]['Image90']) )
						unlink($config['server_path'].'uploads/unit_tops/'.$worktop_exists[0]['Image90']);
					if( is_file($config['server_path'].'uploads/unit_tops/'.$worktop_exists[0]['Image180']) )
						unlink($config['server_path'].'uploads/unit_tops/'.$worktop_exists[0]['Image180']);
					if( is_file($config['server_path'].'uploads/unit_tops/'.$worktop_exists[0]['Image270']) )
						unlink($config['server_path'].'uploads/unit_tops/'.$worktop_exists[0]['Image270']);
				}
				$item = new DbUnitTop($worktop_id);
				$item['IdUnit'] = $unit_found_id;
				$item['IdTop'] = $handle_found['Id'];
				//$pic_0 = $handle['pics'][0];
				$pic_0 = createNewName($config['server_path'].'uploads/unit_tops/','0');
				$pic_1 = createNewName($config['server_path'].'uploads/unit_tops/','1');
				$pic_2 = createNewName($config['server_path'].'uploads/unit_tops/','2');
				$pic_3 = createNewName($config['server_path'].'uploads/unit_tops/','3');
				if( !$debug ){
					copy(str_replace($config['siteurl'],$config['server_path'],$handle['pics'][0]),$config['server_path'].'uploads/unit_tops/'.$pic_0.'.png');
					copy(str_replace($config['siteurl'],$config['server_path'],$handle['pics'][1]),$config['server_path'].'uploads/unit_tops/'.$pic_1.'.png');
					copy(str_replace($config['siteurl'],$config['server_path'],$handle['pics'][2]),$config['server_path'].'uploads/unit_tops/'.$pic_2.'.png');
					copy(str_replace($config['siteurl'],$config['server_path'],$handle['pics'][3]),$config['server_path'].'uploads/unit_tops/'.$pic_3.'.png');
				}
				$item['Image0'] = $pic_0.'.png';
				$item['Image90'] = $pic_1.'.png';
				$item['Image180'] = $pic_2.'.png';
				$item['Image270'] = $pic_3.'.png';
				if( $debug ){
					print_r($item);
				}elseif( $worktop_id > 0 )
					$item->Update();
				else
					$item->CreateNew();
				//print_r($item);
			}
			if( strpos($key,'_variation_') !== false ){
				//continue;
				$handle = $unit['variations'][$key_a[3]];
				$door_found = $handle['door_found'][0];
				$range_found = $handle['range_found'][0];
				$carcass_found = $handle['carcass_found'][0];
				//check if exists
				$variation_exists = new DbList('select * from  unit_variations where IdUnit="'.$unit_found_id.'" and IdDoor="'.$door_found['Id'].'" and IdTexture="'.$range_found['Id'].'" and IdCarcass="'.$carcass_found['Id'].'" order by Id ASC limit 1');
				$variation_id = -1;
				if( $debug ) print_r($variation_exists);
				if( count( $variation_exists ) > 0 && !$debug ){
					$variation_id = $variation_exists[0]['Id'];
					if( is_file($config['server_path'].'uploads/unit_variations/'.$variation_exists[0]['Image0']) )
						unlink($config['server_path'].'uploads/unit_variations/'.$variation_exists[0]['Image0']);
					if( is_file($config['server_path'].'uploads/unit_variations/'.$variation_exists[0]['Image90']) )
						unlink($config['server_path'].'uploads/unit_variations/'.$variation_exists[0]['Image90']);
					if( is_file($config['server_path'].'uploads/unit_variations/'.$variation_exists[0]['Image180']) )
						unlink($config['server_path'].'uploads/unit_variations/'.$variation_exists[0]['Image180']);
					if( is_file($config['server_path'].'uploads/unit_variations/'.$variation_exists[0]['Image270']) )
						unlink($config['server_path'].'uploads/unit_variations/'.$variation_exists[0]['Image270']);
				}
				$item = new DbUnitVariation($variation_id);
				$item['IdUnit'] = $unit_found_id;
				$item['IdDoor'] = $door_found['Id'];
				$item['IdTexture'] = $range_found['Id'];
				$item['IdCarcass'] = $carcass_found['Id'];
				$item['Code'] = !empty( $handle['product_code'] ) ? $handle['product_code'] : '';
				//$pic_0 = $handle['pics'][0];
				$pic_0 = createNewName($config['server_path'].'uploads/unit_variations/','0');
				$pic_1 = createNewName($config['server_path'].'uploads/unit_variations/','1');
				$pic_2 = createNewName($config['server_path'].'uploads/unit_variations/','2');
				$pic_3 = createNewName($config['server_path'].'uploads/unit_variations/','3');
				if( !$debug ){
					copy(str_replace($config['siteurl'],$config['server_path'],$handle['pics'][0]),$config['server_path'].'uploads/unit_variations/'.$pic_0.'.png');
					copy(str_replace($config['siteurl'],$config['server_path'],$handle['pics'][1]),$config['server_path'].'uploads/unit_variations/'.$pic_1.'.png');
					copy(str_replace($config['siteurl'],$config['server_path'],$handle['pics'][2]),$config['server_path'].'uploads/unit_variations/'.$pic_2.'.png');
					copy(str_replace($config['siteurl'],$config['server_path'],$handle['pics'][3]),$config['server_path'].'uploads/unit_variations/'.$pic_3.'.png');
				}
				$item['Image0'] = $pic_0.'.png';
				$item['Image90'] = $pic_1.'.png';
				$item['Image180'] = $pic_2.'.png';
				$item['Image270'] = $pic_3.'.png';
				if( $debug ){
					print_r($item);
				}elseif( $variation_id > 0 )
					$item->Update();
				else
					$item->CreateNew();
				//print_r($item);
			}
		}
		if( $debug ){
			die();
		}	
		Util::Redirect($config['admin_url'].'?page='.$_GET['page']);
		//die();
	}
	
	if( !empty( $_POST['action'] ) && $_POST['action'] == 'generate' ){
		//echo "<pre>";
		$unit_nr = 0;
		while( isset( $_POST['name_'.$unit_nr] ) ){
			if( !empty( $_POST['name_'.$unit_nr] ) ){
				$unit = new DbUnit();
				$unit['Name'] = $_POST['name_'.$unit_nr];
				$unit['Categories'] = '{'.implode('}{',$_POST['categories_'.$unit_nr]).'}';
				$unit['Width'] = $_POST['width_'.$unit_nr];
				$unit['Height'] = $_POST['height_'.$unit_nr];
				$unit['Depth'] = $_POST['depth_'.$unit_nr];
				$unit['DistFromBottom'] = $_POST['dfb_'.$unit_nr];
				$unit['IsFloating'] = !empty( $_POST['dfb_'.$unit_nr] ) ? 1 : 0;
				$unit['HasWorktop'] = $_POST['worktop_'.$unit_nr];
				$unit['HasAppliance'] = $_POST['appliance_'.$unit_nr];
				$from_swf = $config['server_path'].'/admin/swfs/'.$_POST['swf_'.$unit_nr];
				$unit['Swf2D'] = $swf = createNewName($config['server_path'].'uploads/swf_2d/',substr($_POST['swf_'.$unit_nr],0,strlen($_POST['swf_'.$unit_nr])-4)).'.swf';
				copy($from_swf,$config['server_path'].'uploads/swf_2d/'.$unit['Swf2D']);				
				$unit->CreateNew();
			}
			$unit_nr++;
		}
		//echo $unit_nr;
		//print_r($_POST);
		//die();
		Util::Redirect($config['admin_url'].'?page='.$_GET['page']);
	}
	
	function createNewName( $dir, $fname )

	{

		$fname = Util::cleanString(trim($fname),'-',true,false,'-_');

		if( is_file( $dir.$fname.'.png' ) )

			return createNewName($dir,$fname.rand(1000,9999).date('YmdHis'));

		return $fname;

	}
	
	
	$swfs_dir = opendir($config['server_path'].'/admin/swfs/');
	$files = array();
	while( $file = readdir($swfs_dir) ){
		if( substr($file,-4) == '.swf' )
			$files[] = $file;
	}
	$smarty->assign('swfs',$files);
	
	$list = new DbList('select * from units_categories order by IdParent ASC, Name ASC');
	$categs = array();
	foreach( $list as $categ )
	{
		if( $categ['IdParent'] == 0 ) $categs[$categ['Id']] = array_merge($categ,array('categs'=>array()));
		else $categs[$categ['IdParent']]['categs'][] = $categ;
	}
	$smarty->assign('categs',$categs);
	
	//echo "<pre>";
	//print_r($units);
	//die();

?>