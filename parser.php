<?php
error_reporting(0);
/*
 	 __  __                        ____         
 	|  \/  |                      |___ \        
 	| \  / |   ___    ___    ___    __) |   ___ 
 	| |\/| |  / _ \  / __|  / _ \  |__ <   / __|
 	| |  | | | (_) | \__ \ |  __/  ___) | | (__ 
 	|_|  |_|  \___/  |___/  \___| |____/   \___|
                                             
       
	php parser extract ips from masscan result
	C0ded with love by Mose3c
	Usage : php parser.php filename.txt
	fb : https://www.facebook.com/anonsecps
	twitter: https://twitter.com/mohammad_20098

*/

                                 
logo();




# handel arguments from cli 
$args 		  = $argv;
$filename     = $args[1]; # file name
$result_file  = $args[2]; # outfile name
$action  	  = $args[3]; # action name


echo "[*] Filename : $filename\n";
echo "[*] Output   : $result_file\n";

$openfile = fopen($filename,"r+");	// open file .
$readfile = fread($openfile,filesize($filename));	// read file .


//Discovered open port
if(isset($action) && $action == "-p")
{
	$openfile = fopen($filename,"r+");	// open file .
	$count = 0; // count ips 
	while(!feof($openfile))
	{
	
	    $getline = fgets($openfile);
		
		$port = explode("/",$getline);
		$ip   = $port[1];
		$port = $port[0];

		/* Parse result */
		preg_match_all('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $ip, $ips);
		$ips = $ips[0][0]; # ip address 
		$sizeof_ips = sizeof($ips);
		//extract port
		preg_match_all('!\d+!', $port, $matches); // parse port
		$port = $matches[0][0];
		$fullip[] = $ips.":".$port."\n";
		

		$count++;

	}

	echo "[*] Total ips found : $count\n";


	# write result to file outpout . 
	$result_open_file   = fopen($result_file,"w+"); # create output file


	for($i=0;$i<=sizeof($fullip);$i++)
	{
		$write_output 		= fwrite($result_open_file, $fullip[$i]);
	}

}
else
{
	/* Parse result */
	preg_match_all('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $readfile, $ips);
	$ips = $ips[0]; # ip address 
	$sizeof_ips = sizeof($ips);
	echo "[*] Total ips found : $sizeof_ips";
	/* End parsing reuslt */

	# write result to file outpout . 

	$result_open_file   = fopen($result_file,"x+"); # create output file
	for($i=0;$i < $sizeof_ips;$i++)
	{
    	$ips_line = "$ips[$i]\n";
    	$write_output = fwrite($result_open_file, $ips_line);
	}
}









echo "[*] Done.\n";

fclose($openfile);

function logo()
{
	system("clear");
    print"\e[36m
 	 __  __                        ____
  	|  \/  | C0ded with love by.  |___    
 	| \  / |   ___    ___    ___    __) |   ___
 	| |\/| |  / _ \  / __|  / _ \  |__ <   / __|
 	| |  | | | (_) | \__ \ |  __/  ___) | | (__ 
 	|_|  |_|  \___/  |___/  \___| |____/   \___|

 	\e[91m Usage : php parser.php iplist.txt outputfile.txt\n
 	 Usage : php parser.php iplist.txt outputfile.txt -p to parser ip and port 
 	 fb : https://www.facebook.com/anonsecps
	 twitter: https://twitter.com/mohammad_20098
    
     \e[0m\n\n";
}

?>
