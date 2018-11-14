<?php
$access_token = 'ใส่ token bot';

$namebot ='== หลวงปู่เค็ม วัดเขาอีโต้ขว้างเป็ด ==';

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
				$processtext .= "Bot ตัวนี้เกิดขึ้นได้ด้วยบารมีหลวงปู่เค็ม...555"."\n";
				$processtext .= "หากพบปัญหาในการใช้งานแจ้ง ไบรท 0818664561 นะจ๊ะ Line ID : moonoy2820"."\n";
				$processtext .= ""."\n";
				$processtext .= "วิธีการใช้งาน"."\n";
        $processtext .= "- พิมพ์ h ,help เพื่ออ่านคู่มือการใช้งาน"."\n";
        $processtext .= "- พิมพ์ n= หรือ N= แล้วตามด้วยชื่อ หรือนามสกุล หรือชื่อเล่น หรือฉายา หรือหมายเลขโทรศัพท์ครับ"."\n";
				$processtext .= "- พิมพ์ p= หรือ P= แล้วตามด้วยชื่อโรงพัก ชื่อบก. หรือชื่อบช. เพื่อหาข้อมูลได้เลยครับ โดยการใส่ตัวย่อนะครับ"."\n";
				$processtext .= "เช่น p=ก. หรือ หรือ p=ภ.1 หรือ p=บางเขน หรือ p=มุกดาหาร เป็นต้นครับ"."\n";
				$processtext .= ""."\n";
				$processtext .= "   ***การค้นหาระดับบช. ยกเว้น บช.น. จะกดหาไม่ได้ครับ เนื่องจากข้อมูลเยอะเกินว่าที่ไลน์จะแสดงผลได้ในคราเดียว หา น. เฉยๆจะไม่แสดงผลนะครับ ขอให้หาหน่วยที่ย่อยลงมา"."\n";
				$processtext .= ""."\n";
				$processtext .= "   *** ขอบคุณฐานข้อมูลจาก โอ๊ต และขอบคุณข้อมูลเพิ่มเติมจากก๊ง ชมรม + ชื่อเล่น + ฉายาใครผิด โทษไอ้ก๊งนะครับ 555"."\n";
//==========================================elseif
			}elseif ($receivetext=='id' and $userId !='') {

				$processtext =  $namebot."\n";
				$processtext .= "userId = ".$userId."\n";


			}elseif ($receivetext=='gid' and $groupId !='') {

				$processtext = $namebot."\n";
				$processtext .= "groupId = ".$groupId."\n";


//==========================================elseif
			}elseif ($pieces[0]=='n' || $pieces[0]=='N'){

				$jsondata = file_get_contents("pran61Data.json");
				$obj = json_decode($jsondata, true);
				$i = 0;
				foreach($obj as $name) {
						$fname = $name['per_fname'];
						$lname = $name['per_sname'];
            $nname = $name['per_nname'];
            $wname = $name['per_work'];
            $cname = $name['per_class'];
            $pname = $name['per_phone'];
						$nname2 = $name['per_nname2'];
						$nname3 = $name['per_nname3'];
						$ns = $fname." ".$lname;
							if($fname==$pieces[1] || $lname==$pieces[1] || $ns ==$pieces[1] || $nname==$pieces[1] || $wname==$pieces[1] || $cname==$pieces[1] || $pname==$pieces[1] || $pname==$pieces[1] || $nname2 ==$pieces[1] || $nname3 ==$pieces[1]){
								$s[$i] = $name['per_rank'].$name['per_fname']." ".$name['per_sname']." ".$name['per_work']." ".$name['per_nname']." ".$name['per_class']." เบอร์โทร ".$name['per_phone']." "."เบอร์สำรอง"." ".$name['per_band']."  ";
								$i++;
							}
				}
				if (empty($s)) {
					$processtext =   $namebot."\n";
					$processtext .= "ขออภัยไม่พบข้อมูล [".$pieces[1]."]\n";


				}else{
					$c = count($s);
					$processtext = $namebot."\n";
					$processtext .="==มีทั้งสิ้นจำนวน ".$c."=="."\n";

					foreach ($s as $name) {
					$processtext .= $name . "\n";
					}


				}
//==========================================elseif
			}elseif ($pieces[0]=='p' || $pieces[0]=='P'){

				$jsondata = file_get_contents("pran61Data.json");
				$obj = json_decode($jsondata, true);
				$i = 0;
				foreach($obj as $name) {
						$sdname = $name['per_subdivision'];
						$dname = $name['per_division'];
						$bname = $name['per_bureau'];
							if($sdname==$pieces[1] || $dname==$pieces[1] || $bname==$pieces[1]){
								$s[$i] = $name['per_rank'].$name['per_fname']." ".$name['per_sname']." ".$name['per_work']." ".$name['per_nname']." ".$name['per_class']." เบอร์โทร ".$name['per_phone']." "."เบอร์สำรอง"." ".$name['per_band']."  ";
								$i++;
							}
				}
				if (empty($s)) {
					$processtext =   $namebot."\n";
					$processtext .= "ขออภัยไม่พบข้อมูล [".$pieces[1]."]\n";


				}else{
					$c = count($s);
					$processtext = $namebot."\n";
					$processtext .="==มีทั้งสิ้นจำนวน ".$c."=="."\n";

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
