<?php

namespace Kreait\Firebase\Auth;

trait UserInfo
{
    /**
     * @var Name
     */
    protected $displayName;

    /**
     * @var Email Address
     */
    protected $email;

    /**
     * @var Phone Number
     */
    protected $phoneNumber;

    /**
     * @var Photo URL
     */
    protected $photoURL;

    /**
     * @var Provider ID
     */
    protected $providerId;

    /**
     * @var User ID
     */
    protected $uid;

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @return string
     */
    public function getPhotoURL(): string
    {
        return $this->photoURL;
    }

    /**
     * @return string
     */
    public function getProviderId(): string
    {
        return $this->providerId;
    }

    public function setDisplayName(string $displayName)
    {
        $this->displayName = $displayName;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function setPhotoURL(string $photoURL)
    {
        $this->photoURL = $photoURL;
    }

    public function setProviderId(string $providerId)
    {
        $this->providerId = $providerId;
    }

}
