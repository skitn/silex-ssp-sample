<?php

namespace App\Model\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;

final class User implements UserInterface
{
    private $u_id;

    private $nick;

    public function __construct($u_id, $password, $nick)
    {
        $this->u_id = $u_id;
        $this->password = $password;
        $this->nick = $nick;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return [];
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function getUId()
    {
        return $this->u_id;
    }

    public function getNick()
    {
        return $this->nick;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->getUId();
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        $this->setPassword("");
    }
}
