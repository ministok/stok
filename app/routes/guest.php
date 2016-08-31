<?php

$app->get("/",function() use($app){
    $m=new models\BaseModel();
    $app->render("/front/anasayfa.html");
});
$app->notFound(function () use ($app) {

    $mediaType = $app->request->getMediaType();
    $isAPI = (bool) preg_match('|^/api/.*$|', $app->request->getPath());

    if ('application/json' === $mediaType || true === $isAPI) {

        $app->response->headers->set(
            'Content-Type',
            'application/json'
        );

        echo json_encode(
            array(
                'code' => 404,
                'message' => 'Not found'
            )
        );
    }else {
        $app->render('front/404.html');
    }

});

?>