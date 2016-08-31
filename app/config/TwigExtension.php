<?php
namespace config;
use Slim\Slim;
class TwigExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'slim';
    }
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('assets', array($this, 'assetsUrl')),
            new \Twig_SimpleFunction('img', array($this, 'imgUrl')),
            new \Twig_SimpleFunction('getParams', array($this, 'getParams')),
            new \Twig_SimpleFunction('urlFor', array($this, 'urlFor')),
            new \Twig_SimpleFunction('baseUrl', array($this, 'base')),
            new \Twig_SimpleFunction('siteUrl', array($this, 'site')),
            new \Twig_SimpleFunction('currentUrl', array($this, 'currentUrl')),
        );
    }
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFunction('json_encode', array($this, 'jsonEncode'))
        );
    }
    public function jsonDecode($str)
    {
        return json_decode($str);
    }
    public function assetsUrl($a)
    {
        return $this->base()."/assets/".$a;
    }
	public function imgUrl($url,$default)
    {
		if(file_exists($this->base()."/images/".$url))
		{
			return $this->base()."/images/".$url;
		}
		else
		{
			return $this->base()."/assets/images/".$default;
		}
    }
	public function getParams($type="get", $appName = 'default')
    {
       return call_user_func(array(Slim::getInstance($appName)->request,$type));
    }
    public function urlFor($name, $params = array(), $appName = 'default')
    {
        return Slim::getInstance($appName)->urlFor($name, $params);
    }
    public function site($url, $withUri = true, $appName = 'default')
    {
        return $this->base($withUri, $appName) . '/' . ltrim($url, '/');
    }
    public function base($withUri = true, $appName = 'default')
    {
        $req = Slim::getInstance($appName)->request();
        $uri = $req->getUrl();
        if ($withUri) {
            $uri .= $req->getRootUri();
        }
        return $uri;
    }
    public function currentUrl($withQueryString = true, $appName = 'default')
    {
        $app = Slim::getInstance($appName);
        $req = $app->request();
        $uri = $req->getUrl() . $req->getPath();
        if ($withQueryString) {
            $env = $app->environment();
            if ($env['QUERY_STRING']) {
                $uri .= '?' . $env['QUERY_STRING'];
            }
        }
        return $uri;
    }
}