<?
class image_uploader
{
	
	public $file_info = array();
	public $file = array();
	public $pathtofile = '';
	public $new_name = '';
	public $new_file_name = '';
	public $extensii = array('jpg','jpeg','gif','png');
	public $error = false;
	
	function __construct( $file, $dir, $new_name = false, $array_index = false, $extra_extensii = false )
	{
		if( $extra_extensii ) $this->extensii = array_merge($this->extensii,$extra_extensii);
		if( $array_index !== false && is_numeric( $array_index ) )
		{
			$nfile = array();
			foreach( $file as $k => $index )
			{
				$nfile[$k] = $index[$array_index];
			}
			$file = $nfile;
		}
		$this->dir = $dir;
		$this->maxfs = ini_get('upload_max_filesize');
		$this->maxfs = str_replace('M','000000',$this->maxfs);
		$this->maxfs = (int) $this->maxfs;
		$this->file = $file;
		//afla extensia
		$this->file_info = pathinfo($file['name']);
		$this->file_info['filesize'] = filesize($file['tmp_name']);
		if( $new_name === false )
			$this->new_name = $this->createNewName($dir,$this->file_info['filename']);
		else
			$this->new_name = $new_name;
		$this->new_file_name = $this->new_name.'.'.$this->file_info['extension'];
		$this->pathtofile = $dir.$this->new_file_name;
		if( !$this->verificaLimitaKb() )
			$this->error = 'Fisierul uploadat depaseste limita de '.$this->maxfs.'!';
		if( !$this->error && !$this->verificaExtensie() )
			$this->error = 'Fisierul trebuie sa aibe una din extensiile: jpg, jpeg, gif, png!';
		if( !$this->error )
		{
			@move_uploaded_file($file['tmp_name'],$this->pathtofile);
			if( !is_file( $this->pathtofile ) )
				$this->error = 'Eroare! Fisierul nu a putut fi uploadat!';
		}
	}
	
	public function createNewName( $dir, $fname )
	{
		$fname = Util::cleanString(trim($fname),'-',true,false,'-_');
		if( is_file( $dir.$fname.'.'.$this->file_info['extension'] ) )
			return $this->createNewName($dir,$fname.rand(1000,9999).date('YmdHis'));
		return $fname;
	}
	
	public function cropfill( $w, $h, $new_location = false, $move = false, $cropalign = 'middle' )
	{
		if( $new_location )
		{
			copy($this->pathtofile,$new_location);
			if( $move ) unlink( $this->pathtofile );
			if( is_file( $new_location ) ) $this->pathtofile = $new_location;
		}
		$fsize = getimagesize($this->pathtofile);
		//print_r($fsize);
		$rr = $fsize[0]/$w > $fsize[1]/$h ? $fsize[1]/$h : $fsize[0]/$w;
		$nw = ceil($fsize[0]/$rr);
		$nh = ceil($fsize[1]/$rr);
		$cl = 0;
		$ct = 0;
		exec('convert '.$this->pathtofile.'  -resize '.$nw.'x'.$nh.'\>  '.$this->pathtofile.' ');
		switch( $cropalign )
		{
			default:
				$cl = ceil(abs($nw-$w)/2);
				$ct = ceil(abs($nh-$h)/2);
		}
		exec('convert '.$this->pathtofile.' -crop '.$w.'x'.$h.'+'.$cl.'+'.$ct.' '.$this->pathtofile);
	}
	
	public function resize( $w, $h, $new_location = false, $move = false )
	{
		if( $new_location )
		{
			copy($this->pathtofile,$new_location);
			if( $move ) unlink( $this->pathtofile );
			if( is_file( $new_location ) ) $this->pathtofile = $new_location;
		}
		exec('convert '.$this->pathtofile.'  -resize '.$w.'x'.$h.'\>  '.$this->pathtofile.' ');
	}
	
	private function verificaLimitaKb()
	{
		if( $this->file_info['filesize'] > $this->maxfs )
			return false;
		else
			return true;
	}
	
	private function verificaExtensie()
	{
		$this->file_info['extension'] = strtolower($this->file_info['extension']);
		if( !in_array( $this->file_info['extension'], $this->extensii ) )
			return false;
		return true;
	}
}
?>