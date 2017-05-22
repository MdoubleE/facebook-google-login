<?php
include_once 'src/google/Google_Client.php';
include_once 'src/google/contrib/Google_Oauth2Service.php';


$clientId = '1047841883666-qb6g1et2bp1dctfr3lrmo55qo9eqrkjo.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'w6V_YVzySXVqUHkXWWxmj2Ur'; //Google client secret
$gRedirectURL = 'http://www.mytesttodo.me/googleLogin'; //Callback URL
// header('Location:'.filter_var($gRedirectURL,FILTER_SANITIZE_URL));

$gClient = new Google_Client();
$gClient->setApplicationName('Web client 1');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($gRedirectURL);
$gClient->setAccessType('online');
$gClient->setApprovalPrompt('auto') ;
$google_oauthV2 = new Google_Oauth2Service($gClient);
$gloginUrl = $gClient->createAuthUrl();
?>