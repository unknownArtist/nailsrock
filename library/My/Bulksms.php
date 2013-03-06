<?php

/**
 * @author lolkittens
 * @copyright 2012
 */

class My_Bulksms
{

    public static $url = 'http://bulksms.vsms.net/eapi/submission/send_sms/2/2.0';
    public static $msisdn = null;
    public static $username='arafetkanso';
    public static $password='yarakanso';
    protected static $_instance = null;


    public static function getInstance()
    {

        if (null === self::$_instance)
        {
            self::$_instance = new self();
        }

        return self::$_instance;

    }

    public function do_post_request($url, $data, $optional_headers = 'Content-type:application/x-www-form-urlencoded') {
		$params = array('http'      => array(
			'method'       => 'POST',
			'content'      => $data,
			));
		if ($optional_headers !== null) {
			$params['http']['header'] = $optional_headers;
		}
	
		$ctx = stream_context_create($params);


		$response = @file_get_contents($url, false, $ctx);
		if ($response === false) {
			print "Problem reading data from $url, No status returned\n";
		}
	
		return $response;
	}
    public function sendSMS($msisdn, $sms)
    {
        
        $data = 'username='.self::$username.'&password='.self::$password.'&message=' . urlencode( $sms ) .
            '&msisdn=' . urlencode($msisdn);

        $response = self::do_post_request(self::$url, $data);

        if ( strstr($response, 'IN_PROGRESS') ){
            return true;
        } else {
            return false;
        }

    }


}

?>