<?php

namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class AkanetResourceOwner implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    /**
     * Domain
     *
     * @var string
     */
    protected $domain;

    /**
     * Raw response
     *
     * @var array
     */
    protected $response;

    /**
     * Creates new resource owner.
     *
     * @param array $response
     */
    public function __construct(array $response = array())
    {
        $this->response = $response;
    }

    /**
     * Get resource owner id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->getValueByKey($this->response, 'id');
    }

    /**
     * Get resource owner email
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->getValueByKey($this->response, 'email');
    }

    /**
     * Get resource owner name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->getValueByKey($this->response, 'name');
    }

    /**
     * Get resource owner nickname
     *
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->getValueByKey($this->response, 'login');
    }

    /**
     * Get resource owner url
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        $urlParts = array_filter([$this->domain, $this->getNickname()]);

        return count($urlParts) ? implode('/', $urlParts) : null;
    }

    /**
     * Set resource owner domain
     *
     * @param string $domain
     *
     * @return ResourceOwner
     */
    public function setDomain($domain): ResourceOwner
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->response;
    }
}
