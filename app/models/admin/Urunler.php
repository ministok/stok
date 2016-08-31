<?php
namespace models\admin;
use \Eventviva\ImageResize;
use \config\SuperAdmin;
class Urunler extends \models\BaseModel
{
	public $tableName="urunler";
	public $imgSize=["kucuk"=>[250,250],"buyuk"=>[500,500]];
	public function UrunListele($where="1")
	{
		
		$urunler=$this->query("
		SELECT urunler.*,menu.ad as menu_ad FROM `urunler` 
		left join menu on menu.id=urunler.menu_id
		left join menu_tipleri on menu_tipleri.id=menu.tip and menu_tipleri.sayfa='urunler'
		where $where order by sira asc
		")->fetchAll();
		return $urunler;
	}
	public function UrunKaydet($columns)
	{
		$sa= new SuperAdmin;
		if($this->count($this->tableName,[])<$sa->YetkiOzellikleri()["urunsayi"])
		{
			$columns["permalink"]=!isset($columns["permalink"])?$this->permalink($this->tableName,$columns["baslik"]):$columns["permalink"];
			$filename=$columns["filename"];
			unset($columns["filename"]);
			$id=$this->insert($this->tableName,$columns);
			//RESİM KAYDETME
			if(count($_FILES["image"]["name"])>0 && !empty($_FILES["image"]["name"][0]))
			{
				for($i=0;$i<=count($_FILES["image"]["name"])-1;$i++)
				{		
					$uzanti=pathinfo($_FILES["image"]["name"][$i], PATHINFO_EXTENSION);
					$galeri_id=$this->insert("urun_galeri",["urun_id"=>$id,"uzanti"=>".".$uzanti]);
					$image = new ImageResize($_FILES["image"]["tmp_name"][$i]);
					$image->resize($this->imgSize["buyuk"][0],$this->imgSize["buyuk"][1])->save("resimler/urun/$galeri_id.$uzanti");
					$image->resize($this->imgSize["kucuk"][0],$this->imgSize["kucuk"][1])->save("resimler/urun/kucuk/$galeri_id.$uzanti");
				}
			}
			//RESİM KAYDETME
			//DOSYA KAYDETME
			if(isset($_FILES["files"]) && count($_FILES["files"]["name"])>0 && !empty($_FILES["files"]["name"][0]))
			{
				for($i=0;$i<=count($_FILES["files"]["name"])-1;$i++)
				{
					if(!empty($_FILES["files"]["name"][$i]))
					{
						$uzanti=pathinfo($_FILES["files"]["name"][$i], PATHINFO_EXTENSION);
						$dosya_id=$this->insert("urun_dosya",["baslik"=>$filename[$i],"urun_id"=>$id,"uzanti"=>".".$uzanti]);
						move_uploaded_file($_FILES["files"]["tmp_name"][$i],"resimler/urun/dosya/dosya-$dosya_id.$uzanti");
					}
				}
			}
			//DOSYA KAYDETME
			if(!isset($columns["ortak_id"]) || empty($columns["ortak_id"]))
			{
				$this->update($this->tableName,["ortak_id"=>$id],["id"=>$id]);
			}
			else
			{
				$id=$columns["ortak_id"];
			}
			echo $id;
			$this->return=array("error"=>array("message"=>"Ürününüz Kaydedildi","code"=>1));
		}
		else
		{
			$this->return=array("error"=>array("message"=>"Ürününüz Sayınızı Doldurdunuz Daha Fazlası İçin İçin Bize Ulaşın","code"=>0));
		}
		$this->return["redirect"]="/admin/urunler";
		
	}
	public function UrunDuzenle($columns,$where)
	{
		
		$columns["permalink"]=!isset($columns["permalink"])?$this->permalink($this->tableName,$columns["baslik"]):$columns["permalink"];
		$filename=$columns["filename"];
		unset($columns["filename"]);
		if(!empty($where["id"]))
		{
			$this->update($this->tableName,$columns,$where);
		}
		else
		{
			$id=$this->insert($this->tableName,$columns);
			echo $id;
		}
		//RESİM KAYDETME
		if(isset($_FILES["image"]) && count($_FILES["image"]["name"])>0 && !empty($_FILES["image"]["name"][0]))
		{
			for($i=0;$i<=count($_FILES["image"]["name"])-1;$i++)
			{
				$uzanti=pathinfo($_FILES["image"]["name"][$i], PATHINFO_EXTENSION);
				$galeri_id=$this->insert("urun_galeri",["urun_id"=>$columns["ortak_id"],"uzanti"=>".".$uzanti]);
				$image = new ImageResize($_FILES["image"]["tmp_name"][$i]);
				$image->resize($this->imgSize["buyuk"][0],$this->imgSize["buyuk"][1])->save("resimler/urun/$galeri_id.$uzanti");
				$image->resize($this->imgSize["kucuk"][0],$this->imgSize["kucuk"][1])->save("resimler/urun/kucuk/$galeri_id.$uzanti");
			}
		}
		//RESİM KAYDETME
		//DOSYA KAYDETME
		if(isset($_FILES["files"]) && count($_FILES["files"]["name"])>0 && !empty($_FILES["files"]["name"][0]))
		{
			for($i=0;$i<=count($_FILES["files"]["name"])-1;$i++)
			{
				if(!empty($_FILES["files"]["name"][$i]))
				{
					$uzanti=pathinfo($_FILES["files"]["name"][$i], PATHINFO_EXTENSION);
					$dosya_id=$this->insert("urun_dosya",["baslik"=>$filename[$i],"urun_id"=>$columns["ortak_id"],"uzanti"=>".".$uzanti]);
					move_uploaded_file($_FILES["files"]["tmp_name"][$i],"resimler/urun/dosya/dosya-$dosya_id.$uzanti");
				}
			}
		}
		//DOSYA KAYDETME
		$this->return=array("error"=>array("message"=>"Ürününüz Düzenlendi","code"=>1));
		$this->return["redirect"]="/admin/urunler/duzenle/".$columns["ortak_id"];
	}
	
}
?>