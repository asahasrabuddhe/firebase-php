<?php

namespace Kreait\Firebase\Auth;

use Kreait\Firebase\Auth\AuthCredential;

trait OAuthCredential
{
    use AuthCredential;

    /**
     * @var Access Token
     */
    protected $accessToken;

    /**
     * @var Id Token
     */
    protected $idToken;

    /**
     * @var Secret
     */
    protected $secret;

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getIdToken(): string
    {
        return $this->getIdToken;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->getSecret;
    }

    public function setAccessToken(string $accessToken)
    {
        $this->accessToken = $accesToken;
    }

    public function setIdToken(string $idToken)
    {
        $this->idToken = $idToken;
    }

    public function setSecret(string $secret)
    {
        $this->secret = $secret;
    }
}