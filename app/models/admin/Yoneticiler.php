<?php
namespace models\admin;
use \Eventviva\ImageResize;

class Yoneticiler extends \models\BaseModel
{
	public $tableName="admin";
	public $imgWidth=30;
	public $imgHeight=20;
	public function YoneticiListele($where="1")
	{
		$yoneticiler=$this->query("
		select * from $this->tableName where  $where
		")->fetchAll();
		return $yoneticiler;
	}
	public function YoneticiKaydet($columns)
	{
		if(!$this->has($this->tableName,["kullanici_ad"=>$columns["kullanici_ad"]]))
		{
			$columns["sifre"]=md5($columns["sifre"]);
			$id=$this->insert($this->tableName,$columns);
			$this->return=array("error"=>array("message"=>"Yönetici Kaydedildi","code"=>1));
		}
		else
		{
			$this->return=array("error"=>array("message"=>"Bu Yönetici Zaten Var","code"=>0));
		}
		$this->return["redirect"]="/admin/yoneticiler";
		
	}
	public function YoneticiDuzenle($columns,$where)
	{
		if(!empty($where["id"]))
		{
			if(!$this->has($this->tableName,["and"=>["kullanici_ad"=>$columns["kullanici_ad"],"id[!]"=>$where["id"]]]))
			{
				if(!empty($columns["sifre"]))
				{
					$columns["sifre"]=md5($columns["sifre"]);
				}
				else
				{
					unset($columns["sifre"]);
				}
				$this->update($this->tableName,$columns,$where);
				$this->return=array("error"=>array("message"=>"Yoneticiniz Düzenlendi","code"=>1));
			}
			else
			{
				$this->return=array("error"=>array("message"=>"Düzenlenen Yoneticinin Adı Benzersiz Olmalıdır","code"=>0));
			}
		}
		else
		{
			$this->return=array("error"=>array("message"=>"Başka Bir Kayıt Üstünde İşlem Yapmaya Çalışıyorsunuz","code"=>0));
		}
		$this->return["redirect"]="/admin/yoneticiler/duzenle/".$where["id"];
	}
}
?>