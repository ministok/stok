<?php 
namespace models;
class BaseModel
{
	public $db;
	public $pdo;
	public function __construct()
	{
		$this->db=new \medoo(array(
			"charset"=>"utf8",
			"database_type"=>"mysql",
			"database_name"=>"stok",
			"server"=>"127.0.0.1",
			"username"=>"root",
			"password"=>"")
		);
        $this->pdo=$this->db->pdo;
	}
	public function permalink($tableName,$text,$id=NULL)
	{
		$this->tableName=$tableName;
		$search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü');
		$replace =array('c','c','g','g','i','i','o','o','s','s','u','u');
		$text = str_replace($search,$replace,$text);
		$plink = preg_replace("/[^a-zA-Z0-9\/_| -]/", '', $text);
		$plink = strtolower(trim($plink, '-'));
		$new_text = preg_replace("/[\/_| -]+/", '-', $plink);
		if(empty($id))
		{
			$sorgu=$this->select($this->tableName,"permalink",["OR"=>["permalink"=>$new_text,"permalink[~]"=>$new_text."%"]]);
		}
		else
		{
			$sorgu=$this->select($tableName,"perma_link",[
				"OR"=>[
					"permalink"=>$new_text, 
					"permalink[~]"=>$new_text."%", 
				],
				"AND"=>[
					"id[<>]"=>$id
				]
			]);
		}
		//echo $this->last_query();
		if($sorgu != array())
		{
			return $new_text."-".count($sorgu);
		}
		else
		{
			return $new_text;
		}
		
	}
    public function base()
    {
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_URI']
        );
    }
	public function __call($name, $arguments)
	{
		return call_user_func_array(array($this->db,$name),$arguments);
	}
	
}
?>