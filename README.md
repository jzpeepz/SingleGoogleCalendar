# SingleGoogleCalendar
Helps to set up OAuth2 access to to a single user's Google Calendars. This is particularly useful when wanting to pull events to a website or such nonsense.


#Getting Started
* Create a new client ID in the Google API Console.

* Choose "Installed Application" and "Other".

* Pass the Client ID, Client Secret and Redirect URI to the constructor like so:

```php
$cal = new SingleGoogleCalendar(array(
    'clientID' => 'myCrazyClientId',
    'clientSecret' => 'myCrazyClientSecret',
    'redirectURI' => 'myCrazyRedirectUrl'
));
```

* Load 'er up in the browser. You should get a link that ask you to authenticate as the user in question.

* Once authenticated, you will get an **auth code**. Pass that to the constructor like so:

```php
$cal = new SingleGoogleCalendar(array(
    'clientID' => 'myCrazyClientId',
    'clientSecret' => 'myCrazyClientSecret',
    'redirectURI' => 'myCrazyRedirectUrl',
    'authCode' => 'myCrazyAuthCode' // this is where you put the auth code
));
```

* Load 'er up in the browser again.

* Now you should get a **refresh token**. Pass that to the constructor like so:

```php
$cal = new SingleGoogleCalendar(array(
    'clientID' => 'myCrazyClientId',
    'clientSecret' => 'myCrazyClientSecret',
    'redirectURI' => 'myCrazyRedirectUrl',
    'authCode' => 'myCrazyAuthCode',
    'refreshToken' => 'myCrazyRefreshToken' // this is where you put the refresh token
));
```

* Set the calendar that you want to access:

```php
$cal->setCalendarID('your-email@gmail.com'); // this is probably your email but it could be different
```

* Now you are ready to make API queries! You could do something like this:

```php
// this takes raw API parameters
$events = $cal->query(array(
    'singleEvents' => 'true',
    'orderBy' => 'startTime',
    'timeMin' => '2015-04-10T00:00:00Z',
    'maxResults' => 10
));
```

* You (or we) can extend the class to do other things.

# Pull Requests welcome!
