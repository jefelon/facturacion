<?PHP
// namespace startrackexpress\eservices;	// *** Uncomment this line if PHP V5.3 or later ***
// use SoapClient, SoapVar, SoapHeader; 	// *** Uncomment this line if PHP V5.3 or later ***
// Copyright © 2010 StarTrack
// All rights reserved
// <document_root>/MyWebSite/WSSecurity.php
// Class:   WSSoapClient
// StarTrack
// 27 September 2012
// Version 4.5
// Provides WS-Security support for eServices
// Uses PHP5 SOAP extension
/* Calling sequence (use in place of SoapClient):
  require_once WSSecurity.php;
  $wsdl = "WSDL address";
  $oSC = new WSSoapClient($wsdl, $arguments);
  $oSC->__setUsernameToken('username', 'passphrase');
  $params = array(    ); 		// The service parameters
  $result=$oSC->__soapCall('method_name', $params);
*/
class WSSoapClient extends SoapClient
{
    public $_class='WSSSOAPCLIENT_';
	private $username;
	private $password;
    private $SSLForce;
    private $cacert;
    private function generatePasswordDigest()
    {
        // Can use rand() to repeat the word if the server is under high load
        $this->nonce = mt_rand();
        $this->timestamp = gmdate('Y-m-d\TH:i:s\Z');
        $packedNonce = pack('H*', $this->nonce);
        $packedTimestamp = pack('a*', $this->timestamp);
        $packedPassword = pack('a*', $this->password);
        $hash = sha1($packedNonce . $packedTimestamp . $packedPassword);
        $packedHash = pack('H*', $hash);
        return base64_encode($packedHash);
    }

// Generates a WS-Security header
	private function WsSecurityHeader()
	{
        $passwordDigest = $this->generatePasswordDigest();
        // Use PasswordText authentication
        $created = gmdate('Y-m-d\TH:i:s\Z');
        $nonce = mt_rand();
        $authentication = '
<wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
<wsse:UsernameToken wsu:Id="UsernameToken-1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
    xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
    <wsse:Username>' . $this->username . '</wsse:Username>
    <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordDigest">' .$passwordDigest. '</wsse:Password>
    <wsse:Nonce>' . base64_encode(pack('H*', $nonce)) . '</wsse:Nonce>
    <wsu:Created xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">' . $created . '</wsu:Created>
   </wsse:UsernameToken>
</wsse:Security>
';
		$authValues = new SoapVar($authentication, XSD_ANYXML);
		$header = new SoapHeader("http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd", "Security",$authValues, true);
		return $header;
	}
	// Sets a username and passphrase
	public function __setUsernameToken($username,$password)
	{
		$this->username = $username;
		$this->password = $password;
	}

    public function __setSSLForce($ver, $cacert){
        $this->SSLForce = $ver;
        $this->cacert   = $cacert;
    }
	// Overrides the original method, adding the security header
	public function __soapCall($function_name, $arguments, $options=NULL, $input_headers=NULL, &$output_headers=NULL)
	{
        $_procedure = $this->_class."SOAPCALL: ";
		try
		{
            if(WOOTRACK_DEBUG) {

                error_log($_procedure.'function_name: '.serialize($function_name));
                error_log($_procedure.'arguments: '.serialize($arguments));
                error_log($_procedure.'options: '.serialize($options));
                error_log($_procedure.'WsSecurityHeader: '.serialize($this->WsSecurityHeader()));
            }
			$result = parent::__soapCall($function_name, $arguments, $options, $this->WsSecurityHeader());
            var_dump($result);
			return $result;
		}
		catch (SoapFault $e)
		{
			throw new SoapFault($e->faultcode, $e->faultstring, NULL);//, $e->detail);
		}
	}

	public function __doRequest($request, $location, $action, $version, $one_way=NULL)
	{
        $_procedure = $this->_class."DO_REQUEST: ";
		if(WOOTRACK_DEBUG) {
            error_log($_procedure."Request XML Prior to __doRequest".serialize($request) );
            error_log($_procedure."location: ".serialize($location));
            error_log($_procedure."action: ".serialize($action));
            error_log($_procedure."version: ".serialize($version));
            error_log($_procedure."one_way: ".serialize($one_way));
        }
		if( $this->SSLForce )
		{
            if(WOOTRACK_DEBUG) error_log($_procedure."FORCE SSL: ".serialize($this->SSLForce) );
            $h = curl_init( $location );		// Init with URL
            curl_setopt( $h, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $h, CURLOPT_HTTPHEADER, Array( "SOAPAction: $action", "Content-Type: text/xml; charset=utf-8" ) );
            curl_setopt( $h, CURLOPT_POSTFIELDS, $request );
            curl_setopt( $h, CURLOPT_SSLVERSION, $this->SSLForce );
            curl_setopt( $h, CURLOPT_SSL_VERIFYHOST, false );				// Omit validation of the StarTrack server's
                                                                                // Verisign SSL certificate (not recommended)
            curl_setopt( $h, CURLOPT_CAINFO, $this->cacert );						// On Windows, cURL needs to be told about Verisign root cert
            $response = curl_exec( $h );										// Perform SOAP call
            if( empty( $response ) )
            {
                throw new SoapFault( 'CURL Error: '.curl_error( $h ), curl_errno( $h ) );
            }
            curl_close( $h );
            return $response;
		}
		else
		{
            if(WOOTRACK_DEBUG) error_log($_procedure."NO FORCE SSL" );
			return parent::__doRequest($request, $location, $action, $version);	// No, use default SSL/TLS
		}
	}
}

$wsdl = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService?wsdl';

$arguments=array('trace' => true);

try {
    $client = new WSSoapClient($wsdl, $arguments);
} catch(Exception $e) {
    var_dump($e);
}
?>
