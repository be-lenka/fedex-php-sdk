<?php

namespace belenka\fedex\Authorization;

use Exception;
use InvalidArgumentException;

final class AuthorizationResponseDto
{
    private string $accessToken;

    private string $tokenType;

    private int $expiresIn;

    private string $scope;

    public function getAccessToken(): string
    {
        if ($this->accessToken !== null && !isset($this->accessToken)) {
            throw new Exception('uninitialized attribute');
        }

        return $this->accessToken;
    }

    public function setAccessToken($accessToken): self
    {
        if (!is_string($accessToken)) {
            throw new InvalidArgumentException('invalid type');
        }

        $this->accessToken = $accessToken;

        return $this;
    }

    public function getTokenType(): string
    {
        if ($this->tokenType !== null && !isset($this->tokenType)) {
            throw new Exception('uninitialized attribute');
        }

        return $this->tokenType;
    }

    public function setTokenType($tokenType): self
    {
        if (!is_string($tokenType)) {
            throw new InvalidArgumentException('invalid type');
        }

        $this->tokenType = $tokenType;

        return $this;
    }

    public function getExpiresIn(): int
    {
        if ($this->expiresIn !== null && !isset($this->expiresIn)) {
            throw new Exception('uninitialized attribute');
        }

        return $this->expiresIn;
    }

    public function setExpiresIn($expiresIn): self
    {
        if (!is_int($expiresIn)) {
            throw new InvalidArgumentException('invalid type');
        }

        $this->expiresIn = $expiresIn;

        return $this;
    }

    public function getScope(): string
    {
        return $this->scope;
    }

    public function setScope($scope): self
    {
        if (!is_string($scope)) {
            throw new InvalidArgumentException('invalid type');
        }

        $this->scope = $scope;

        return $this;
    }

    private function checkUninitializedAttribute()
    {
        if ($this->accessToken !== null && !isset($this->accessToken)) {
            throw new Exception('uninitialized attribute');
        }
    }
}
