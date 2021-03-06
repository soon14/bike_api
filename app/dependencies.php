<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// handler
$container['foundHandler'] = function() {
    return new \Slim\Handlers\Strategies\RequestResponseArgs();
};

// doctrine
$container['doctrine.dbal.conn.default'] = function ($c) {
    $settings = $c->get('settings')['doctrine']['dbal']['conn']['default'];
    return Doctrine\DBAL\DriverManager::getConnection($settings);
};

// dao primary
$container['bike.api.dao.primary.user'] = function ($c) {
    $settings = $c->get('settings')['dao']['primary'];
    return new Bike\Api\Db\Primary\UserDao(
        $c->get($settings['conn_id']),
        $settings['db_name'],
        $settings['prefix'],
        'Bike\Api\Db\Primary\User'
    );
};

$container['bike.api.dao.primary.bike'] = function ($c) {
    $settings = $c->get('settings')['dao']['primary'];
    return new Bike\Api\Db\Primary\BikeDao(
        $c->get($settings['conn_id']),
        $settings['db_name'],
        $settings['prefix'],
        'Bike\Api\Db\Primary\Bike'
    );
};

$container['bike.api.dao.primary.bike_id_generator'] = function ($c) {
    $settings = $c->get('settings')['dao']['primary'];
    return new Bike\Api\Db\Primary\BikeIdGeneratorDao(
        $c->get($settings['conn_id']),
        $settings['db_name'],
        $settings['prefix'],
        'Bike\Api\Db\Primary\BikeIdGenerator'
    );
};

$container['bike.api.dao.primary.option'] = function ($c) {
    $settings = $c->get('settings')['dao']['primary'];
    return new Bike\Api\Db\Primary\OptionDao(
        $c->get($settings['conn_id']),
        $settings['db_name'],
        $settings['prefix'],
        'Bike\Api\Db\Primary\Option'
    );
};

// dao oauth2
$container['bike.api.dao.oauth2.client'] = function ($c) {
    $settings = $c->get('settings')['dao']['oauth2'];
    return new Bike\Api\Db\OAuth2\ClientDao(
        $c->get($settings['conn_id']),
        $settings['db_name'],
        $settings['prefix'],
        'Bike\Api\Db\OAuth2\Client'
    );
};

$container['bike.api.dao.oauth2.scope'] = function ($c) {
    $settings = $c->get('settings')['dao']['oauth2'];
    return new Bike\Api\Db\OAuth2\ScopeDao(
        $c->get($settings['conn_id']),
        $settings['db_name'],
        $settings['prefix'],
        'Bike\Api\Db\OAuth2\Scope'
    );
};

// service
$container['bike.api.service.user'] = function ($c) {
    return new Bike\Api\Service\UserService($c);
};

$container['bike.api.service.oauth2'] = function ($c) {
    return new Bike\Api\Service\OAuth2Service($c);
};

$container['bike.api.service.sms'] = function ($c) {
    return new Bike\Api\Service\SmsService($c);
};

$container['bike.api.service.bike'] = function ($c) {
    return new Bike\Api\Service\BikeService($c);
};

$container['bike.api.service.push'] = function ($c) {
    return new Bike\Api\Service\PushService($c);
};

$container['bike.api.service.api'] = function ($c) {
    return new Bike\Api\Service\ApiService($c);
};

$container['bike.api.service.option'] = function ($c) {
    return new Bike\Api\Service\OptionService($c);
};

$container['bike.api.service.alipay'] = function ($c) {
    return new Bike\Api\Service\AlipayService($c);
};

// redis conn
$container['bike.api.redis.conn.default'] = function ($c) {
    $settings = $c->get('settings')['redis']['conn']['default'];
    return new Bike\Api\Redis\Connection(
        $settings['host'],
        $settings['port'],
        $settings['timeout'],
        $settings['password']
    );
};

// redis dao
$container['bike.api.redis.dao.access_token'] = function ($c) {
    $accessTokenDao = new Bike\Api\Redis\Dao\AccessTokenDao();
    $accessTokenDao->setConn($c->get('bike.api.redis.conn.default'));
    return $accessTokenDao;
};

$container['bike.api.redis.dao.refresh_token'] = function ($c) {
    $refreshTokenDao = new Bike\Api\Redis\Dao\RefreshTokenDao();
    $refreshTokenDao->setConn($c->get('bike.api.redis.conn.default'));
    return $refreshTokenDao;
};

$container['bike.api.redis.dao.auth_code'] = function ($c) {
    $authCodeDao = new Bike\Api\Redis\Dao\AuthCodeDao();
    $authCodeDao->setConn($c->get('bike.api.redis.conn.default'));
    return $authCodeDao;
};

$container['bike.api.redis.dao.sms_code'] = function ($c) {
    $smsCodeDao = new Bike\Api\Redis\Dao\SmsCodeDao();
    $smsCodeDao->setConn($c->get('bike.api.redis.conn.default'));
    return $smsCodeDao;
};
