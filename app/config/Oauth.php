<?php
namespace config;

class Oauth
{
	public $app;
	public function __construct($app)
	{
		$this->app=$app;
	}
	public function Login()
	{
        $m=new \models\BaseModel();
        $api_key=$this->app->request->headers("ApiKey");
        if(!($api_key && $m->has("cihazlar",["api_key"=>$api_key]) && $this->app->request->getMediaType()=='application/json'))
        {
            $this->app->response->headers->set(
                'Content-Type',
                'application/json'
            );
            $this->app->halt(401, json_encode(
                array(
                    'code' => 404,
                    'message' => 'Not found'
                )
            ));
        }
	}
} 
?>