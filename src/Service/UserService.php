<?php

namespace Bike\Api\Service;

use Bike\Api\Exception\Debug\DebugException;
use Bike\Api\Exception\Logic\LogicException;
use Bike\Api\Service\AbstractService;
use Bike\Api\Util\ArgUtil;
use Bike\Api\Db\Primary\User;

class UserService extends AbstractService
{
    public function getUserByMobile($mobile)
    {
        $key = 'user.mobile.' . $mobile;
        $user = $this->getRequestCache($key);
        if (!$user) {
            $userDao = $this->getUserDao();
            $user = $userDao->find(array(
                'mobile' => $mobile,
            ));
            if ($user) {
                $this->setUserRequestCache($user);
            }
        }
        return $user;
    }

    public function getUser($id)
    {
        $key = 'user.' . $id;
        $user = $this->getRequestCache($key);
        if (!$user) {
            $userDao = $this->getUserDao();
            $user = $userDao->find($id);
            if ($user) {
                $this->setUserRequestCache($user);
            }
        }
        return $user;
    }

    public function hashPassword($password)
    {
        $options = [
            'cost' => 10,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];

        return  password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    protected function setUserRequestCache(User $user)
    {
        $mobikeKey = 'user.mobile.' . $user->getMobile();
        $idKey = 'user.' . $user->getId();
        $this->setRequestCache($mobikeKey, $user);
        $this->setRequestCache($idKey, $user);
    }

    protected function getUserDao()
    {
        return $this->container->get('bike.api.dao.primary.user');
    }
}