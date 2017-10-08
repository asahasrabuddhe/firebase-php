<?php

namespace Kreait\Firebase\Auth;

trait AuthCredential 
{
    /**
     * @var Provider ID
     */
    protected $providerId;

    /**
     * @return string
     */
    public function getProviderId(): string
    {
        return $this->providerId;
    }

    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;
    }
}