<?
class image_uploader
{
	
	public $file_info = array();
	public $file = array();
	public $new_name = '';
	public $new_file_name = '';
	public $extensii = array('jpg','jpeg','gif','png');
	public $error = false;
	
	function __construct( $file, $dir, $new_name = false )
	{
		$this->maxfs = ini_get('upload_max_filesize');
		$this->maxfs = str_replace('M','000000',$this->maxfs);
		$this->maxfs = (int) $this->maxfs;
		$this->file = $file;
		if( $new_name === false )
			$this->new_name = date('YmdHis');
		else
			$this->new_name = $new_name;
		//afla extensia
		$this->file_info = pathinfo($file['name']);
		$this->file_info['filesize'] = filesize($file['tmp_name']);
		$this->new_file_name = $this->new_name.'.'.$this->file_info['extension'];
		if( !$this->verificaLimitaKb() )
			$this->error = 'Fisierul uploadat depaseste limita de '.$this->maxfs.'!';
		if( !$this->error && !$this->verificaExtensie() )
			$this->error = 'Fisierul trebuie sa aibe una din extensiile: jpg, jpeg, gif, png!';
		if( !$this->error )
		{
			@move_uploaded_file($file['tmp_name'],$dir.$this->new_file_name);
			if( !is_file( $dir.$this->new_file_name ) )
				$this->error = 'Eroare! Fisierul nu a putut fi uploadat!';
		}
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
		if( !in_array( $this->file_info['extension'], $this->extensii ) )
			return false;
		return true;
	}
}
?>