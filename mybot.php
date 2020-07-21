<?php
/*
Author : Mohammad Erfan Gooneh
*/
include("Telegram.php");

// Set the bot TOKEN
$bot_id = "YOUR_TOKEN"; 

$telegram = new Telegram($bot_id);
require 'vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;
$result = $telegram->getData();
$text 			   = $telegram->Text();
$chat_id 		   = $telegram->ChatID();
$user_id		   = $telegram->UserID();
$username 		   = $telegram->Username();
$name 		  	   = $telegram->FirstName();
$family 		   = $telegram->LastName();
$callback_data     = $telegram->Callback_Data();
$callback_query    = $telegram->Callback_Query();
$callback_chat_id  = $telegram->Callback_ChatID();
$callback_id	   = $telegram->Callback_ID();
$message_id 	   = $telegram->MessageID();
$admins = YOUR_CHAT_ID;
$channel_name 	  = '@YOUR_CHANNEL';
mkdir("data");
mkdir("data/$chat_id");
unlink("error_log");
$ad  = file_get_contents("data/channel.txt");
$stat = file_get_contents("data/$chat_id/stat.txt");
$stepadmin = file_get_contents("data/stepadmin.txt");

//Counting members
	$user = file_get_contents("analyze/count.txt");
    $member_id = explode("\n",$user);
    $member_count = count($member_id)-1 ;
//begin
$host_url = 'YOUR_HOST_DOMAIN';

$msgType = $telegram->getUpdateType();
function logoWatermark1($file_name){
	
	$dest = 'tmp_img/';
	
	// open an image file -- BackGround
	$img = Image::make($dest.$file_name);

    // open an image file
	
    // resize image to fixed size
    $img->resize(400,400);

	// and insert a watermark for example
	$img->insert('1.png','center');

	// finally we save the image as a new file
	$new_name = 'wm_'.mt_rand(10000,99999999999).'.jpg';
	$img->save($dest.$new_name);
	unlink($dest.$file_name);
	return $new_name;
}
//Count command
if($text == "/count" ){
$content = array('chat_id' => $chat_id, 'text' => "
🚻✌  تعداد افراد کمپین #نه_به_امتحانات_حضوری :  $member_count 
 ");
	$telegram->sendMessage($content);
						}
//Start command
if($text == '/start'){
	if($stat != 1){
$content = array('chat_id' => $chat_id, 'text' => "
✌✊ شما هم به کمپین #نه_به_امتحان_حضوری پیوستید و نام شما در سیستم ثبت گردید

🎫 جهت دریافت نشانی پروفایل خود یک عکس ارسال نمایید !

💠 به اشتراک بگذارید : @azcamp_bot
	");
	$telegram->sendMessage($content);
$content = array('chat_id' => $chat_id, 'text' => "
🌀 سلام  ، $name به کمپین #نه_به_امتحان_حضوری خوش اومدی !

📜 شما نفر $member_count هستید که در این کمپین عضو میشوید .

🔸تو این کمپین ما اعتراضمون رو به شیوه ی قانونی و درستش بیان میکنیم 
	
🔹 ما تو این کمپین به شدت مخالف برگذاری امتحانات حضوری هستیم
	
🔸 به نظر ما سلامتی خیلی مهم تره
	
🔹اما هیچ توهینی هم به هیچ نهادی نمیکنیم ! اما نهادا در جریان اعتراض ما قرار بگیرن!!!!
	
✊ #نه_به_امتحانات_حضوری

🍁 جهت اسپانسرینگ و تامین هزینه ی بات  : info.azcamp@gmail.com

💠 به اشتراک بگذارید : @azcamp_bot
	");
	$telegram->sendMessage($content);
$content = array('chat_id' => $chat_id, 'text' => "
جهت دریافت گواهی و نشانی کمپین ، یک عکس ارسال کنید .
");
	
	$telegram->sendMessage($content);
	$content = array('chat_id' => $channel_name, 'text' => "💠کسی استارت زد:
	نام و نام خانوادگی : $name , $family
	چت آیدی : $chat_id
	@$username");
	$telegram->sendMessage($content);
	file_put_contents("data/$chat_id/stat.txt","1");
	$user = file_get_contents('analyze/count.txt');
    $members = explode("\n",$user);
    if (!in_array($chat_id,$members)){
      $add_user = file_get_contents('analyze/count.txt');
      $add_user .= $chat_id."\n";
     file_put_contents('analyze/count.txt',$add_user);
    }
}
else{
$content = array('chat_id' => $chat_id, 'text' => "
🌀 سلامی دوباره ، $name
            
✔ کمپین #نه_به_امتحانات_حضوری
				
💠 به اشتراک بگذارید : @azcamp_bot
				");
	$telegram->sendMessage($content);
}
}
// Photo 
if($msgType == 'photo'){
$content = ['chat_id' => $user_id, 'text' => 'در حال پردازش تصویر شما..'];
	$telegram->sendMessage($content);
	
	$file_id = $telegram->bigPhotoFileID();
	
	$file = $telegram->getFile($file_id);
	$file_path = $file['result']['file_path'];
	$full_path ='https://api.telegram.org/file/bot'.$bot_id.'/'.$file_path;

	$file_name = 'image_'.mt_rand(1,100000).'.jpg';
	file_put_contents('tmp_img/'.$file_name,file_get_contents($full_path));

	$new_file = logoWatermark1($file_name);
	$new_full_path = $host_url.'/tmp_img/'.$new_file;
	
	$content = ['chat_id' => $user_id, 'caption' => '
	✌ من به کمپین #نه_به_امتحانات_حضوری پیوستم
💎آیدی بات کمپین : https://t.me/azcamp_bot', 'photo' => $new_full_path];
	$telegram->sendPhoto($content);
$finalMsg = '
✌ من به کمپین #نه_به_امتحانات_حضوری پیوستم
⭕️ با توجه به فشار روحی و افزایش مبتلایان بیماری کرونا ما از آموزش و پرورش درخواست میکنیم که امتحانات حضوری را لغو کند ! 

▪️شما می تونید با انتشار دادن عکس آواتار خودتون از این کمپین دانش آموزی حمایت کنید .
    
🌀 برای عضویت در پویش :  @azcamp_bot
    


🌺با آرزوی سلامتی همه ی مردم دنیا ، انشاالله هیچکس هم به مشکل اقتصادی برنخوره
    
🔸🔹🔸🔹🔸🔹
    
💠 به اشتراک بگذارید : @azcamp_bot
 ';
	$content = array('chat_id' => $chat_id, 'text' => $finalMsg);
	$telegram->sendMessage($content);
    $content = array('chat_id' => $channel_name , 'text' => "گواهی دریافت کرد :
    $name , $family
    $chat_id , @$username");
   	$telegram->sendMessage($content);
	
}
// ob_end_flush();
