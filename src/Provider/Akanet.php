<?php

namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\Exception\AkanetIdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Akanet extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * Domain
     *
     * @var string
     */
    public $domain = 'https://akanet3.it-akademy.fr';

    /**
     * Api domain
     *
     * @var string
     */
    public $apiDomain = 'https://akanet3.it-akademy.fr/api/v1';

    /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl(): string
    {
        return $this->domain . '/oauth/authorize';
    }

    /**
     * Get access token url to retrieve token
     *
     * @param array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return $this->domain . '/oauth/access_token';
    }

    /**
     * Get provider url to fetch user details
     *
     * @param AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        if ($this->domain === 'https://akanet3.it-akademy.fr') {
            return $this->apiDomain . '/api/v1/user';
        }
        return $this->domain . '/user';
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes(): array
    {
        return [];
    }

    /**
     * Check a provider response for errors.
     *
     * @param  ResponseInterface $response
     * @param  array             $data     Parsed response data
     * @return void
     *@throws IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, array $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw AkanetIdentityProviderException::clientException($response, $data);
        } elseif (isset($data['error'])) {
            throw AkanetIdentityProviderException::oauthException($response, $data);
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param  array       $response
     * @param  AccessToken $token
     * @return ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token): ResourceOwnerInterface
    {
        $user = new AkanetResourceOwner($response);

        return $user->setDomain($this->domain);
    }
}
