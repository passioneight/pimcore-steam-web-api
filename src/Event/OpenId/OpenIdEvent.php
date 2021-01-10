<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class OpenIdEvent extends Event
{
    private UserInterface $user;
    private Response $response;

    /**
     * OpenIdEvent constructor.
     * @param UserInterface $user
     * @param string $translationKey
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @return string
     */
    abstract public function getTranslationKey(): string;

    /**
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}
