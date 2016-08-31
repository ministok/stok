<?php 
namespace config;
class SuperAdmin extends \models\BaseModel
{
	public $sol_menu=
	[
		
		"urunler"=>
		[
			"ikon"=>"briefcase",
			"link"=>"urunler",
			"baslik"=>"ÜRÜNLER"
		],
		"sayfalar"=>
		[
			"ikon"=>"file-text",
			"link"=>"sayfalar",
			"baslik"=>"SAYFALAR"
		],
		"menu"=>
		[
			"ikon"=>"bars",
			"link"=>"menu",
			"baslik"=>"MENÜLER"
		],
		"duyurular"=>
		[
			"ikon"=>"bullhorn",
			"link"=>"duyurular",
			"baslik"=>"DUYURULAR"
		],
		"referanslar"=>
		[
			"ikon"=>"external-link-square",
			"link"=>"referanslar",
			"baslik"=>"REFERANSLAR"
		],
		"haberler"=>
		[
			"ikon"=>"newspaper-o",
			"link"=>"haberler",
			"baslik"=>"HABERLER"
		],
		"galeriler"=>
		[
			"ikon"=>"camera",
			"link"=>"galeriler",
			"baslik"=>"GALERİ"
		],
		"iletisim"=>
		[
			"ikon"=>"envelope",
			"link"=>"iletisim/duzenle",
			"baslik"=>"İLETİŞİM"
		],
		"moduller"=>
		[
			"ikon"=>"commenting",
			"link"=>"#",
			"baslik"=>"MODÜLLER",
			"cocuk"=>
			[
				"anketler"=>
				[
					"ikon"=>"question",
					"link"=>"anketler",
					"baslik"=>"ANKETLER"
				],
				"bloklar"=>
				[
					"ikon"=>"th-large",
					"link"=>"bloklar",
					"baslik"=>"BLOKLAR"
				]
			]
		],
		"slaytlar"=>
		[
			"ikon"=>"picture-o",
			"link"=>"slaytlar",
			"baslik"=>"SLAYTLAR"
		],
		"dosyalar"=>
		[
			"ikon"=>"download",
			"link"=>"indirmeler",
			"baslik"=>"İNDİRMELER"
		],
		"admin"=>
		[
			"ikon"=>"user",
			"link"=>"yoneticiler"
			,
			"baslik"=>"YÖNETİCİLER"
		],
		"ik"=>
		[
			"ikon"=>"users",
			"link"=>"ik",
			"baslik"=>"İŞ BAŞVURULARI"
		],
		"diller"=>
		[
			"ikon"=>"language",
			"link"=>"diller",
			"baslik"=>"DİLLER"
		],
		"ceviri"=>
		[
			"ikon"=>"exchange",
			"link"=>"ceviriler",
			"baslik"=>"ÇEVİRİLER"
		],
		"ayarlar"=>
		[
			"ikon"=>"cog",
			"link"=>"ayarlar/duzenle/",
			"baslik"=>"AYARLAR"
		]
	];
	public $yetkiler=
	[
		"mini"=>
		[
			"urunsayi"=>10,
			"menuler"=>["ceviri","menu","slaytlar","admin","ik"]
		],
		"eko"=>
		[
			"urunsayi"=>25,
			"menuler"=>["ceviriler","menu","slaytlar"]
		],
		"standart"=>
		[
			"urunsayi"=>50,
			"menuler"=>["ceviriler","slaytlar"]
		],
		"pro"=>
		[
			"urunsayi"=>1000,
			"menuler"=>[]
		]
	];
	public function YetkiKontrol($uri)
	{
		$superAdmin=$this->get("super_admin","*",[]);
		$uri=explode("/",$uri);
		if(isset($uri[2]) && in_array($uri[2],$this->yetkiler[$superAdmin["paket"]]["menuler"]) )
		{
			$this->return["redirect"]="/admin";
		}
	}
	public function YetkiOzellikleri()
	{
		$paket=$this->get("super_admin","paket",[]);
		return $this->yetkiler[$paket];
	}
	public function SolMenuListe()
	{
		$superAdmin=$this->get("super_admin","*",[]);
		if(!isset($_SESSION["superadmin"]))
		{
			foreach($this->yetkiler[$superAdmin["paket"]]["menuler"] as $paket)
			{
				unset($this->sol_menu[$paket]);
			}
		}
		else
		{
			$this->sol_menu["superadmin"]=
			[
				"ikon"=>"rocket",
				"link"=>"super-admin",
				"baslik"=>"SÜPER ADMİN"
			];
		}
			
		return $this->sol_menu;
		
	}
	public function SuperAdminDuzenle($columns)
	{
		if(!empty($columns["sifre"]))
		{
			$columns["sifre"]=md5($columns["sifre"]);
		}
		else
		{
			unset($columns["sifre"]);
		}
		$this->update("super_admin",$columns);
		echo str_replace('"',"",$this->last_query());
		
		$this->return=array("error"=>array("message"=>"Yekiler Düzenlendi","code"=>1));
		$this->return["redirect"]="/admin/super-admin";
		
	}
}
?>