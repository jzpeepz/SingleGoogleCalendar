<?php
class SingleGoogleOAuth
{

    public $calendarID;
    public $scope;
    public $clientID;
    public $clientSecret;
    public $redirectURI;
    public $authCode;
    public $refreshToken;
    public $accessToken;
    
    public function __construct($params = array())
    {
        foreach ($params as $key => $param)
        {
            $this->$key = $param;
        }
        
        // check for minimum requirements
        if (! isset($this->clientID) || empty($this->clientID))
            die('FAILED: Please pass clientID from the API Console!');
            
        if (! isset($this->clientSecret) || empty($this->clientSecret))
            die('FAILED: Please pass clientSecret from the API Console!');
            
        if (! isset($this->redirectURI) || empty($this->redirectURI))
            die('FAILED: Please pass redirectURI from the API Console!');
            
        // generate link to get the authCode
        if (! isset($this->authCode) || empty($this->authCode))
        {
            $this->linkToAuthCode();
        }
        // display the refresh token
        elseif (! isset($this->refreshToken) || empty($this->refreshToken))
        {
            $this->displayRefreshToken();
        }
        
        $this->accessToken = $this->getAccessToken();
    }
    
    private function linkToAuthCode()
    {
        $rsParams = array(
            'response_type' =>   'code',
            'client_id'     =>   $this->clientID,
            'redirect_uri'  =>   $this->redirectURI,
            'scope'         =>   $this->scope
        );

        $cOauthURL = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query($rsParams);
    
        die('Visit the link below and pass the given value as authCode:<br><a href="' . $cOauthURL . '" target="_blank">Get authCode</a>');
    }
    
    private function displayRefreshToken()
    {
        $cTokenURL = 'https://accounts.google.com/o/oauth2/token';
        
        $rsPostData = array(
            'code'          =>   $this->authCode,
            'client_id'     =>   $this->clientID,
            'client_secret' =>   $this->clientSecret,
            'redirect_uri'  =>   $this->redirectURI,
            'grant_type'    =>   'authorization_code',
        );

        $cTokenReturn = $this->httpPost($cTokenURL, $rsPostData);

        $oToken = json_decode($cTokenReturn);

        die("Your refresh token: " . $oToken->refresh_token);
    }
    
    private function getAccessToken()
    {
        // Get a new Access Token
        $cTokenURL = 'https://accounts.google.com/o/oauth2/token';
        
        $rsPostData = array(
            'client_secret' =>   $this->clientSecret,
            'grant_type'    =>   'refresh_token',
            'refresh_token' =>   $this->refreshToken,
            'client_id'     =>   $this->clientID
        );

        $cTokenReturn = $this->httpPost($cTokenURL, $rsPostData);

        $oToken = json_decode($cTokenReturn);

        return $oToken->access_token;
    }

    public function getAuthHeader()
    {
        return "Authorization: OAuth " . $this->accessToken;
    }

    public function apiGet($url)
    {
        $ch = curl_init();
     
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($this->getAuthHeader()));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
        return curl_exec($ch);
    }

    public function httpPost($url, $data)
    {
        $ch = curl_init();
     
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
        return curl_exec($ch);
    }

}