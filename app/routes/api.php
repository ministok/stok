<?php

function login(\Slim\Route $route)
{
    $app = \Slim\Slim::getInstance();
    $oauth=new config\Oauth($app);
    $oauth->login();
}
$app->group("/api",'login',function() use($app){

    $app->post("/a",function() use($app){
        $m=new models\BaseModel();
        //$app->render("/front/guest/anasayfa.html",[]);
    })->name("adam");
    $app->get("/a",function() use($app){
        $m=new models\BaseModel();
        //$app->render("/front/guest/anasayfa.html",[]);
    })->name("adam");

});
$app->get("/b",function() use($app){

    $ourRoute = $app->router->getNamedRoute('adam');
    $ourRoute->setParams(array("a" => "fasfas"));
    $_POST = array('a'=>'Abasasassaas');
    $result = $ourRoute->dispatch();
    echo $result;

});
$app->get("/auth",function() use($app){

    try {
        $app->setEncryptedCookie('uid', 'demo', '5 minutes');
        $app->setEncryptedCookie('key', 'demo', '5 minutes');
    } catch (Exception $e) {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
    }

});
$app->get("/control",function() use($app)
{
    print_r($app->request->cookies);
});
$app->get("/curl",function() use($app){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://localhost:8080/stok/api/a");
    $headers = array();
    $headers[] = 'ApiKey: 1234567';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $server_output = curl_exec ($ch);
    //echo $server_output;
    curl_close ($ch);
});
?>