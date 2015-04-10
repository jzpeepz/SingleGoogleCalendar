<?php

class SingleGoogleCalendar extends SingleGoogleOAuth
{

    public function __construct($params = array())
    {
        // sane defaults
        $this->scope = 'https://www.googleapis.com/auth/calendar';
        
        parent::__construct($params);
    }
    
    public function setCalendarID($calendarID)
    {
        $this->calendarID = $calendarID;
    }
    
    public function getEvents()
    {
        $cCalURL = 'https://www.googleapis.com/calendar/v3/calendars/' . $this->calendarID . '/events';
     
        $cJsonReturn = $this->apiGet($cCalURL);
     
        return json_decode($cJsonReturn);
    }

    public function query($params = array())
    {
        $url = 'https://www.googleapis.com/calendar/v3/calendars/' . $this->calendarID . '/events';

        $queryString = http_build_query($params);

        $url = $url . '?' . $queryString;

        $cJsonReturn = $this->apiGet($url);
     
        return json_decode($cJsonReturn);
    }
}