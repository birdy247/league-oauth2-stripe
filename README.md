README
========

Stripe OAuth2 provider for [League\OAuth2-Client](https://github.com/thephpleague/oauth2-client).

Usage
=======

First, add `chrsm/league-oauth2-stripe` to your `composer.json`.

Here's a (simple) example of how this package can be used:

    <?php

    require_once 'vendor/autoload.php';

    use chrsm\oauth2\Stripe as StripeProvider;
    use chrsm\oauth2\StripeAuthorizationCode;

    $stripe = new StripeProvider([
        'clientId' => 'Your Stripe Client ID',
        'clientSecret' => 'Your Stripe Secret Key',
        'redirectUri' => 'URL where you would like Stripe to redirect your user to post-auth',
    ]);

    // psuedo-code, but you get the idea..
    if (!isset($tokenVariableFromStripe)) {
        header('Location: ' . $stripe->getAuthorizationUrl());
    } else {
        $token = $stripe->getAccessToken(
            new StripeAuthorizationCode,
            [
                'code' => $tokenVariableFromStripe,
                'grant_type' => 'authorization_code',
            ]
        );

        // save what you want
        $accessToken = $token->accessToken;
        $refreshToken = $token->refreshToken;
        $publishableKey = $token->stripePublishableKey;
    }

    // .... elsewhere, once you have acquired an access token:
    Stripe::setApiKey($accessToken);

Additionally, you can use the Publishable Key retrieved in Stripe Checkout
(or basically anywhere you'd need a Stripe PK).
