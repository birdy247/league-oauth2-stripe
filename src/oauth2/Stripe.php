<?php
namespace chrsm\oauth2;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Entity\User;

class Stripe extends AbstractProvider
{
	public $scopes = ['read_write'];
	public $responseType = 'json';
	
	public function urlAuthorize()
	{
		return 'https://connect.stripe.com/oauth/authorize';
	}

	public function urlAccessToken()
	{
		return 'https://connect.stripe.com/oauth/token';
	}

	public function urlUserDetails(AccessToken $token)
	{
		return '';
	}

	public function userDetails($response, AccessToken $token)
	{
		return new User();
	}

	public function userUid($response, AccessToken $token)
	{
		return;
	}

	public function userEmail($response, AccessToken $token)
	{
		return;
	}

	public function userScreenName($response, AccessToken $token)
	{
		return;
	}
}
