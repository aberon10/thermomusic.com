<?php

namespace App\Libs;

class GoogleAuth
{
    private $client;

    public function __construct($google_client = null) {
        $this->client = $google_client;

        if ($this->client) {
            $this->client->setClientId(getenv('GO_ID_CLIENT_GOOGLE'));
            $this->client->setClientSecret(getenv('GO_CLIENT_SECRETE'));
            $this->client->setRedirectUri(getenv('GO_URI_REDIRECT'));
            $this->client->setScopes(['profile', 'email']);
        }
    }

    public function isLoggedIn() {
        return isset($_SESSION['access_token']);
    }

    public function getAuthUrl() {
        return $this->client->createAuthUrl();
    }

    public function checkRedirectCode() {
        if (isset($_GET['code'])) {
            $this->client->authenticate($_GET['code']);
            $this->setToken($this->client->getAccessToken());
            return true;
        }
        return false;
    }

    public function setToken($token) {
        $_SESSION['access_token'] = $token;
        $this->client->setAccessToken($token);
    }

    public function getDataUser() {
        return $this->client->verifyIdToken();
    }
}
