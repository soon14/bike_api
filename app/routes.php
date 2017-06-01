<?php
// Routes
$app->get('/', 'Bike\Api\Controller\IndexController:indexAction');

$app->group('/oauth2', function () {
    $this->post('/authorize', 'Bike\Api\Controller\OAuth2\IndexController:authorizeAction');
    $this->post('/access_token', 'Bike\Api\Controller\OAuth2\IndexController:accessTokenAction');
});

$app->group('/v1', function () {
    $this->get('/user/test', 'Bike\Api\Controller\User\IndexController:testAction');

    // sms
    $this->get('/sms/get_login_code', 'Bike\Api\Controller\Sms\IndexController:getLoginCodeAction');
})->add(function ($request, $response, $next) {
    try {
        $server = $this->get('bike.api.service.oauth2')->createResourceServer();
        $request = $server->validateAuthenticatedRequest($request);
        return $next($request, $response);
    } catch (\Exception $e) {
        $exception = new \Bike\Api\Exception\Logic\InvalidAccessTokenException();
        return $response->withJson(array(
            'errno' => $exception->getCode(),
            'errmsg' => $exception->getMessage(),
        ));
    }
});
