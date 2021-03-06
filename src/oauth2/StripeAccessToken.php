<?php
namespace chrsm\oauth2;

use League\OAuth2\Client\Token\AccessToken as AccessTokenBase;
use InvalidArgumentException;

class StripeAccessToken extends AccessTokenBase
{
    /**
     * @var  string  accessToken
     */
    public $accessToken;

    /**
     * @var  int  expires
     */
    public $expires;

    /**
     * @var  string  refreshToken
     */
    public $refreshToken;

    /**
     * @var  string  uid
     */
    public $uid;

    public $stripePublishableKey;
    public $stripeUserId;

    /**
     * Sets the token, expiry, etc values.
     *
     * @param  array $options token options
     * @return void
     */
    public function __construct(array $options = null)
    {
        if (! isset($options['access_token'])) {
            throw new \InvalidArgumentException('Required option not passed: access_token'
                                                 . PHP_EOL.print_r($options, true));
        }

        $this->accessToken = $options['access_token'];

        // Some providers (not many) give the uid here, so lets take it
        isset($options['uid']) and $this->uid = $options['uid'];

        // Vkontakte uses user_id instead of uid
        isset($options['user_id']) and $this->uid = $options['user_id'];

        // Mailru uses x_mailru_vid instead of uid
        isset($options['x_mailru_vid']) and $this->uid = $options['x_mailru_vid'];

        // We need to know when the token expires, add num. seconds to current time
        isset($options['expires_in']) and $this->expires = time() + ((int) $options['expires_in']);

        // Facebook is just being a spec ignoring jerk
        isset($options['expires']) and $this->expires = time() + ((int) $options['expires']);

        // Grab a refresh token so we can update access tokens when they expires
        isset($options['refresh_token']) and $this->refreshToken = $options['refresh_token'];

        isset($options['stripe_publishable_key']) and $this->stripePublishableKey = $options['stripe_publishable_key'];
        isset($options['stripe_user_id']) and $this->stripeUserId = $options['stripe_user_id'];
    }

    /**
     * Returns the token key.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->accessToken;
    }
}
