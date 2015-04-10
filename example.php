<?php
include 'lib/SingleGoogleOAuth.php';
include 'lib/SingleGoogleCalendar.php';

// 1. Create a new client ID in the Google API Console
// 2. Choose "Installed Application" and "Other"
// 3. Pass the Client ID, Client Secret and Redirect URI

$cal = new SingleGoogleCalendar([
    'clientID' => '',
    'clientSecret' => '',
    'redirectURI' => '',
    'authCode' => '',
    'refreshToken' => '',
]);

$cal->setCalendarID('your-email@gmail.com'); // this is probably your email but it could be different

$events = $cal->query(array(
    'singleEvents' => 'true',
    'orderBy' => 'startTime',
    'timeMin' => '2015-04-10T00:00:00Z',
    'maxResults' => 10
));

var_dump($events);