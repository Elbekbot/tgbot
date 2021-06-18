<?php

    date_default_timezone_set("Asia/kolkata");
    //Data From Webhook
    $content = file_get_contents("php://input");
    $update = json_decode($content, true);
    $chat_id = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];
    $message_id = $update["message"]["message_id"];
    $id = $update["message"]["from"]["id"];
    $username = $update["message"]["from"]["username"];
    $firstname = $update["message"]["from"]["first_name"];
    $chatname = $_ENV['CHAT']; 
 /// for broadcasting in Channel
$channel_id = "-100xxxxxxxxxx";

/////////////////////////

    //Extact match Commands
    if($message == "/start"){
        send_message($chat_id,$message_id, "Hey $firstname \nUse /cmds to view commands \n$chatname");
    }

    if($message == "/cmds" || $message == "/cmds@github_rbot"){
        send_message($chat_id,$message_id, "
          /search <query> (Google search)
          \n/bin <bin> (Bin Data)
          \n/weather <name of your city> (Current weather Status)
          \n/dice <dice emoji>
          \n/date (today's date)
          \n/dict <word> (Dictionary)
          \n/time (current time) 
          \n/git <username> (Github User Info)
          \n/repodl <username/repo_name> (Download Github Repository)
          \n/cryptorate
          \n/toss (Random Heads or Tails)
          \n/syt <query> (Search on Youtube)
          \n/info (User Info)
          ");
    }
      if($message == "/cryptorate" || $message == "/cryptorate@github_rbot"){

        send_message($chat_id,$message_id,"
	 Use command to check current Crypto rates
         \n/btcrate  Bitcoin rate
         \n/ethrate  Etherum rate
         \n/ltcrate  Litecoin rate
         ");
    }

    if($message == "/date"){
        $date = date("d/m/y");
        send_message($chat_id,$message_id, $date);
    }
   if($message == "/help"){
        $help = "Contact @reboot13_dev";
        send_message($chat_id,$message_id, $help);
    }
   if($message == "/time"){
        $time = date("h:i a", time());
        send_message($chat_id,$message_id, "$time IST");
    }

  if($message == "/sc" || $message == "/si" || $message == "/st" || $message == "/cs" || $message == "/ua" || $message == "/at"  ){
   $botdown = "@WorldCheckerBot is under Maintenance";
        send_message($chat_id,$message_id, $botdown);
    }

if($message == "/dice"){
        sendDice($chat_id,$message_id, "🎲");
    }




if($message == "/toss"){
      $toss =array("Heads","Tails","Heads","Tails","Heads");
    $random_toss=array_rand($toss,4);
    $tossed = $toss[$random_toss[0]];
        send_message($chat_id,$message_id, "$tossed \nTossed By: @$username");
    }

     if($message == "/info"){
        send_message($chat_id,$message_id, "User Info \nName: $firstname\nID:$id \nUsername: @$username");
    }




///Commands with text


    //Google Search
if (strpos($message, "/search") === 0) {
        $search = substr($message, 8);
         $search = preg_replace('/\s+/', '+', $search);
$googleSearch = "[View On Web](https://www.google.com/search?q=$search)";
    if ($googleSearch != null) {
     send_MDmessage($chat_id,$message_id, $googleSearch);
    }
  }

if (strpos($message, "/repodl") === 0) {
$gitdlurl = substr($message, 8);
$gitdlurl1 = "[Click here](https://github.com/$gitdlurl/archive/master.zip)";
if ($gitdlurl != null) {
  send_MDmessage($chat_id,$message_id, "https://github.com/$gitdlurl/archive/main.zip
 \n⬇️In Case of no preview⬇️ \n$gitdlurl1"  );
}
}

//Youtube Search
if (strpos($message, "/syt") === 0) {
$syt = substr($message, 5);
$syt = preg_replace('/\s+/', '+', $syt);
$yurl = "[Open Youtube](https://www.youtube.com/results?search_query=$syt)";
if ($syt != null) {
  send_MDmessage($chat_id,$message_id, $yurl);
}
}


///Channel BroadCast
if (strpos($message, "/broadcast") === 0) {
$broadcast = substr($message, 11);
if ($id == 1171876903 /*|| $id == 1478297206 || $id == 654455829 || $id == 638178378 || $id == 971532801*/ ) { // || uncomment for multiple admins
  send_Cmessage($channel_id, $broadcast);
}
else {
    send_message($chat_id,$message_id, "You are not authorized to use this command");
 // example
///send_message("-100xxxxxxxxxx",$message_id, "You are not authorized to use this command");
///send_message("@channel_username",$message_id, "You are not authorized to use this command");
/// You can add as many channel and chat you want use the above format (make sure bot is promoted as admin in chat and channel)
}

}


//Bin Lookup
if(strpos($message, "/bin") === 0){
    $bin = substr($message, 5);
    $curl = curl_init();
    curl_setopt_array($curl, [
    CURLOPT_URL => "https://binssuapi.vercel.app/api/".$bin,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
    "accept-language: en-GB,en-US;q=0.9,en;q=0.8,hi;q=0.7",
    "sec-fetch-dest: document",
    "sec-fetch-site: none",
    "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1"
   ],
   ]);

 $result = curl_exec($curl);
 curl_close($curl);
 $data = json_decode($result, true);
 $bank = $data['data']['bank'];
 $country = $data['data']['country'];
 $brand = $data['data']['vendor'];
 $level = $data['data']['level'];
 $type = $data['data']['type'];
$flag = $data['data']['countryInfo']['emoji'];
 $result1 = $data['result'];

    if ($result1 == true) {
    send_MDmessage($chat_id,$message_id, "***✅ Valid BIN
Bin: $bin
Brand: $brand
Level: $level
Bank: $bank
Country: $country $flag
Type:$type
Checked By @$username ***");
    }
else {
    send_MDmessage($chat_id,$message_id, "***Enter Valid BIN***");
}
}

    //Wheather API
if(strpos($message, "/weather") === 0){
        $location = substr($message, 9);
        $weatherToken = "89ef8a05b6c964f4cab9e2f97f696c81"; ///get api key from openweathermap.org

   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "http://api.openweathermap.org/data/2.5/weather?q=$location&appid=$weatherToken",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 50,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"Accept: */*",
        "Accept-Language: en-GB,en-US;q=0.9,en;q=0.8,hi;q=0.7",
        "Host: api.openweathermap.org",
        "sec-fetch-dest: empty",
		"sec-fetch-site: same-site"
  ],
]);


$content = curl_exec($curl);
curl_close($curl);
$resp = json_decode($content, true);

$weather = $resp['weather'][0]['main'];
$description = $resp['weather'][0]['description'];
$temp = $resp['main']['temp'];
$humidity = $resp['main']['humidity'];
$feels_like = $resp['main']['feels_like'];
$country = $resp['sys']['country'];
$name = $resp['name'];
$kelvin = 273;
$celcius = $temp - $kelvin;
$feels = $feels_like - $kelvin;

if ($location = $name) {
        send_MDmessage($chat_id,$message_id, "***
Weather at $location: $weather
Status: $description
Temp : $celcius °C
Feels Like : $feels °C
Humidity: $humidity
Country: $country 
Checked By @$username ***");
}
else {
           send_message($chat_id,$message_id, "Invalid City");
}
    }

///Github User API
if(strpos($message, "/git") === 0){
  $git = substr($message, 5);
   $curl = curl_init();
   curl_setopt_array($curl, [
CURLOPT_URL => "https://api.github.com/users/$git",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 50,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
    "Accept-Encoding: gzip, deflate, br",
    "Accept-Language: en-GB,en;q=0.9",
    "Host: api.github.com",
    "Sec-Fetch-Dest: document",
    "Sec-Fetch-Mode: navigate",
    "Sec-Fetch-Site: none",
    "Sec-Fetch-User: ?1",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36"
  ],
