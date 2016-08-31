<?php 
namespace config;
class session
{
	public static function prefix()
	{
		return "tuyan_";
	}
	public static function yeni($ad,$deger=NULL,$expires=NULL)
	{
		if(is_array($ad))
		{
			foreach($ad as $idx=>$a)
			{
				$_SESSION[Session::prefix().$idx]=$a;
			}
		}
		else
		{
			return $_SESSION[Session::prefix().$ad]=$deger;
		}
	}
	public static function sil($ad)
	{
		if(is_array($ad))
		{
			foreach($ad as $a)
			{
				unset($_SESSION[Session::prefix().$a]);
			}
		}
		else
		{
			unset($_SESSION[Session::prefix().$ad]);
		}
	}
	public static function kontrol($ad)
	{
		return isset($_SESSION[Session::prefix().$ad]) && !empty($_SESSION[Session::prefix().$ad])?1:0;
	}
	public static function oku($ad)
	{
		return @$_SESSION[Session::prefix().$ad];
	}
	public static function tumu()
	{
		$session=[];
		foreach($_SESSION as $idx=>$ses)
		{
			$session[str_replace(Session::prefix(),"",$idx)]=$ses;
		}
		return @$session;
	}
	
}
?>