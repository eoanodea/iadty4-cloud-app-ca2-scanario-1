<?php
require_once(__DIR__ . '/../vendor/autoload.php');
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;

class Auth {
    private static $key = "ASIA4RELRWZWZKV7GSW3";
    private static $secret = "Pm2Hf8f13q687FbP1xqJj1Rx/pZigDGcwKqua9n";
    private static $region = "us-east-1";
    private static $version = "2016-04-18";
    public static $url = "https://festival-app.auth.us-east-1.amazoncognito.com/login?client_id=788pbdt0lnh6o7taenjn40g8h3&response_type=token&scope=aws.cognito.signin.user.admin+email+openid+profile&redirect_uri=http://localhost:8888/festivalCloud/index.php";

    public $access_token = null;
    public $email;
    public $phone;
    public $isLoggedIn=false;    

    public function __construct() {        
        if(isset($_GET["access_token"])) {
            $this->authenticate();
        }
    }

    public function getEmail() {
        return $this->email;
    }

    public function loggedIn() {
        return $this->isLoggedIn;
    }

    public function getAccessToken() {
        return $this->access_token;
    }

    public static function getSignInURL() {
        return Auth::$url;
    }


    public function authenticate() {
        $this->access_token = htmlspecialchars($_GET["access_token"]);
      
        $client = new CognitoIdentityProviderClient([
            'version' => Auth::$version,
            'region' => Auth::$region,
            'credentials' => [
                            'key'    => Auth::$key,
                            'secret' => Auth::$secret,
                        ],
        ]);
        
        try {
            //Get the User data by passing the access token received from Cognito
            $result = $client->getUser([
                'AccessToken' => $this->access_token,
            ]);
            
                
            //Iterate all the user attributes and get email and phone number
            $userAttributesArray = $result["UserAttributes"];
            foreach ($userAttributesArray as Auth::$key => $val) {
                if($val["Name"] == "email"){
                    $this->email = $val["Value"];
                }
                if($val["Name"] == "phone_number"){
                    $this->phone = $val["Value"];
                }
            }	

            $this->isLoggedIn = true;
          
            if(isset($_GET["logout"]) && $_GET["logout"] == 'true'){
                //This will invalidate the access token
                $result = $client->globalSignOut([
                    'AccessToken' => $this->access_token,
                ]);
                
                header("Location: " + $this->url);
            }
            
            
        } catch (\Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException $e) {
            echo 'FAILED TO VALIDATE THE ACCESS TOKEN. ERROR = ' . $e->getMessage();
        } catch (\Aws\Exception\CredentialsException $e) {
            echo 'FAILED TO AUTHENTICATE AWS KEY AND SECRET. ERROR = ' . $e->getMessage();
        }
    }
}

