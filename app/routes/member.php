<?php
$authenticate = function ($app,$route="") {
    return function () use ($app) {
        if ((!$app->session->kontrol('user') && !$app->session->kontrol('uye_tip'))) {
            $app->flash('notice',array("message"=>"Giriş Yapmalısınız!","code"=>0));
            $app->redirect('/giris-yap');
        }
		if($app->session->oku('firma_id')==0 && stristr($_SERVER["REDIRECT_URL"], "/profil"))
		{
			$app->redirect('/firma-ekle');
		}
    };
};
?>