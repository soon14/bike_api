<?php
// Routes
$app->get('/', 'Bike\\Api\\Controller\\IndexController:indexAction');

$app->group('/oauth2', function () {
    $this->post('/authorize', 'Bike\\Api\\Controller\\OAuth2\\IndexController:authorizeAction');
    $this->post('/access_token', 'Bike\\Api\\Controller\\OAuth2\\IndexController:accessTokenAction');
    $this->get('/test', 'Bike\\Api\\Controller\\OAuth2\\IndexController:testAction');
});
