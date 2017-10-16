<?php

namespace Kreait\Firebase\Auth;

use Kreait\Firebase\Auth\UserInfo;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Token;

class User
{
    use UserInfo;
    
    /**
     * @var Token
     */
    private $idToken;

    /**
     * @var string
     */
    private $refreshToken;

    public static function create($idToken = null, string $refreshToken = null): self
    {
        $idToken = $idToken instanceof Token ?: (new Parser())->parse($idToken);

        $user = new static();
        $user->setIdToken($idToken);
        $user->setRefreshToken($refreshToken);

        foreach($idToken->getClaims() as $key => $claim)
        {
            switch($key)
            {
                case 'user_id':
                    $user->uid = (string) $user->idToken->getClaim('user_id');
                    break;
                case 'name':
                    $user->setDisplayName((string) $user->idToken->getClaim('name'));
                    break;
                case 'picture':
                    $user->setPhotoURL((string) $user->idToken->getClaim('email'));
                    break;
                case 'email':
                    $user->setEmail((string) $user->idToken->getClaim('email'));
                    break;
                case 'firebase':
                    $user->setProviderId($user->idToken->getClaim('firebase')->sign_in_provider);
                default:
                    break;
            }
        }

        return $user;
    }

    public function setIdToken(Token $token)
    {
        $this->idToken = $token;
    }

    public function setRefreshToken(string $refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return string
     */
    public function getUid(): string
    {
        /* @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->uid;
    }

    /**
     * @return Token
     */
    public function getIdToken(): Token
    {
        return $this->idToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function update(array $data): void
    {
        $this->setDisplayName($data['displayName']);
        $this->setPhotoURL($data['photoUrl']);
    }
}
