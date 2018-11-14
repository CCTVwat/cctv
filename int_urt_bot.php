<?php
$access_token = '4ocF6luoPn3l4Lcw965O4to73wyH1I3nD8fP+ot8CLu98tStGqQUP3ctx9bz6qCB4u9gEX1GX4L9FnUfVRziCIPNjHy6djOih5+k2hh0fY8YOy3dJm5pOqfBG7AHfzxXTBnF85O8L+UD3XpoVyrN+wdB04t89/1O/w1cDnyilFU=';

$namebot ='== สมุดโทรศัพท์ กก.สส.ภ.จว.สุราษฎร์ธานี ==';

date_default_timezone_set('Asia/Bangkok');



$help_array = array("h", "H", "help", "HELP", "Help", "บอทใช้ยังไง", "บอท");



// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
    // Reply only when message sent is in 'text' format

		$groupId = $event['source']['groupId'];
		$timestamp = $event['timestamp'];
		$userId = $event['source']['userId'];
		$replyToken = $event['replyToken'];
		$receivetext = $event['message']['text'];
    $pieces = explode("=", $receivetext);
		//get profile
		$url = 'https://api.line.me/v2/bot/profile/'. $userId ;
		$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$output = curl_exec($ch);
		curl_close($ch);
		$profile = json_decode($output, true);
		$displayName = $profile['displayName'];
		$pictureUrl = $profile['pictureUrl'];
		$statusMessage = $profile['statusMessage'];


		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			//source


				if(in_array($receivetext, $help_array)){
				$processtext =  $namebot."\n";
				$processtext .= "Bot ตัวนี้ทำขึ้นเพื่อความสะดวกในการค้นหาข้อมูลของ ข้าราชการตำรวจ กก.สส.ภ.จว.สุราษฎร์ธานี"."\n";
				$processtext .= ""."\n";
				$processtext .= "หากพบปัญหาในการใช้งานแจ้ง สว.โอ๊ต 080 6466880 นะจ๊ะ"."\n";
				$processtext .= "วิธีการใช้งาน"."\n";
                $processtext .= "- พิมพ์ h ,help เพื่ออ่านคู่มือการใช้งาน"."\n";
                $processtext .= "- พิมพ์ n= หรือ N= แล้วตามด้วยชื่อ หรือนามสกุล หรือชื่อเล่น หรือหมายเลขโทรศัพท์ครับ"."\n";
				$processtext .= "- พิมพ์ p= หรือ P= แล้วตามด้วยชื่อสังกัด หรือหน้างานที่ปฏิบัติ เพื่อหาข้อมูลได้เลยครับ "."\n";
				$processtext .= ""."\n";
				$processtext .= "   *** ขอบคุณฐานข้อมูลจาก หนิง กก.สส.ฯ และ มว.กริช ฯ "."\n";
//==========================================elseif
			}elseif ($receivetext=='id' and $userId !='') {

				$processtext =  $namebot."\n";
				$processtext .= "userId = ".$userId."\n";


			}elseif ($receivetext=='gid' and $groupId !='') {

				$processtext = $namebot."\n";
				$processtext .= "groupId = ".$groupId."\n";


//==========================================elseif
			}elseif ($pieces[0]=='n' || $pieces[0]=='N'){

				$jsondata = file_get_contents("Int_Srt.json");
				$obj = json_decode($jsondata, true);
				$i = 0;
				foreach($obj as $name) {
						$fname = $name['per_fname'];
						$lname = $name['per_sname'];
            			$nname = $name['per_nname'];
           				$pname = $name['per_phone'];
						$nname2 = $name['per_nname2'];
						$ns = $fname." ".$lname;
							if($fname==$pieces[1] || $lname==$pieces[1] || $ns ==$pieces[1] || $nname==$pieces[1] || $pname==$pieces[1] || $pname==$pieces[1] || $nname2 ==$pieces[1] ){
								$s[$i] = $name['per_rank'].$name['per_fname']." ".$name['per_sname']." ".$name['per_work']." ".$name['per_nname']."  เบอร์โทร ".$name['per_phone']." "." ตำแหน่ง "." ".$name['per_position']."  ";
								$i++;
							}
				}
				if (empty($s)) {
					$processtext =   $namebot."\n";
					$processtext .= " AppDoll ไม่พบข้อมูลนะจ๊ะนาย [".$pieces[1]."]\n";


				}else{
					$c = count($s);
					$processtext = $namebot."\n";
					$processtext .="== AppDoll พบข้อมูลจำนวน ".$c."=="."\n";

					foreach ($s as $name) {
					$processtext .= $name . "\n";
					}


				}
//==========================================elseif
			}elseif ($pieces[0]=='p' || $pieces[0]=='P'){

				$jsondata = file_get_contents("Int_Srt.json");
				$obj = json_decode($jsondata, true);
				$i = 0;
				foreach($obj as $name) {
						$wname = $name['per_work'];
						$dname = $name['per_position'];
						$bname = $name['per_divition'];
							if($wname==$pieces[1] || $dname==$pieces[1] || $bname==$pieces[1]){
								$s[$i] = $name['per_rank'].$name['per_fname']." ".$name['per_sname']." ".$name['per_work']." ".$name['per_nname']." เบอร์โทร ".$name['per_phone']." "." ตำแหน่ง "." ".$name['per_position']."  ";
								$i++;
							}
				}
				if (empty($s)) {
					$processtext =   $namebot."\n";
					$processtext .= " AppDoll ไม่พบข้อมูลนะจ๊ะนาย [".$pieces[1]."]\n";


				}else{
					$c = count($s);
					$processtext = $namebot."\n";
					$processtext .="==AppDoll พบข้อมูลจำนวน  ".$c."=="."\n";

					foreach ($s as $name) {
					$processtext .= $name . "\n";
					}


				}

	}



      // Build message to reply back
      $messages = [
        'type' => 'text',
        'text' => $processtext
      ];

      $url = 'https://api.line.me/v2/bot/message/reply';
      $data = [
        'replyToken' => $replyToken,
        'messages' => [$messages],
      ];

      $post = json_encode($data);
      $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $result = curl_exec($ch);
      curl_close($ch);

      echo $result . "\r\n";

	}

  }
}
echo "OK";

?>
