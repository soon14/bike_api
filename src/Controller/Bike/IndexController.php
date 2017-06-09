<?php

namespace Bike\Api\Controller\Bike;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Bike\Api\Controller\AbstractController;
use Bike\Api\Db\Primary\Bike;
use Bike\Api\Vo\ApiBike;

class IndexController extends AbstractController
{
    // 假数据
    public function indexAction(Request $request, Response $response)
    {
        $lat = $request->getQueryParam('lat');
        $lng = $request->getQueryParam('lng');
        $range = number_format($request->getQueryParam('range'), 1);// 小数点一位
        $list = array();
        $bikeService = $this->container->get('bike.api.service.bike');
        for ($i = 0; $i < 20; $i++) {
            $bike = new Bike();

            $bike->setId($bikeService->generateBikeId());
            $diff = mt_rand(0, $range * 10) / 2220;
            if (mt_rand(0, 1)) {
                $diff = 0 - $diff;
            }
            $bike
                ->setLat($lat + $diff)
                ->setLng($lng + $diff);
            $apiBike = new ApiBike();
            $apiBike->fromBike($bike);
            $list[] = $apiBike->toArray();
        }
        $data['list'] = $list;
        return $this->jsonSuccess($response, $data);
    }
}
