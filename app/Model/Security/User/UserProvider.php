<?php

namespace App\Model\Security\User;

use App\Model\Security\User\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        $data_list = [
            "aaa@aaa.com" => ["u_id" => 1, "pass" => "aaa", "nick" => "nick_aaa"],
            "bbb@bbb.com" => ["u_id" => 2, "pass" => "bbb", "nick" => "nick_bbb"]
        ];

        if (! isset($data_list[$username])) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        $user = $data_list[$username];
        return new User($user['u_id'], $user['pass'], $user['nick']);
    }

    public function refreshUser(UserInterface $user)
    {
        $data_list = [
            1 => ["u_id" => 1, "pass" => "aaa", "nick" => "nick_aaa"],
            2 => ["u_id" => 2, "pass" => "bbb", "nick" => "nick_bbb"]
        ];

        if (! isset($data_list[$user->getUId()])) {
            throw new UsernameNotFoundException(sprintf('u_id "%s" does not exist.', $user->getUId()));
        }

        $user = $data_list[$user->getUId()];
        $userObj = new User($user['u_id'], $user['pass'], $user['nick']);
        $userObj->eraseCredentials();
        return $userObj;
    }

    public function supportsClass($class)
    {
        return $class === 'App\Model\Security\User\User';
    }
}
