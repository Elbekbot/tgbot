<?php

ob_start();

$API_KEY = "1816118743:AAGCq_ULdgknSZbp347vn8a3nG5k5_Je6Mc";
define('API_KEY',$API_KEY);
function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
}
}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$text = $message->text;
$mid = $message->message_id;
$lan = file_get_contents("lan/$chat_id.txt");
$language =json_encode([
            'resize_keyboard'=>true,
           'keyboard'=>[['text'=>"O'zbek"],['text'=>"Russki"]],
           
          ]);
          switch($lan){
            case "Uz": $txt = "Jamoaviy anketa📄";
            $txt2 = "Shaxsiy anketa📄" break;
            case "Ru": $txt = "Анкета участника 📄";
            $txt2 = "Командная анкета 📄" break;
          }
$anketa =json_encode([
            'resize_keyboard'=>true,
           'keyboard'=>[]
           [['text'=>"$txt"],['text'=>"$txt2"]],
           [['text'=>"🔝 Главное Меню"]]
           ]
          ]);
        mkdir("step");
        mkdir("lan");
if($text=="/start"){
bot('sendMessage',[
'chat_id'=>$chat_id , 
'text'=>"Tilni tanlang",
]);
file_put_contents("step/$chat_id.step","Lan");
}

if(isset($text)){
  if(file_get_contents("step/$chat_id.step") == "Lan"){
    if($text == "O'zbek"){
      file_put_contents("lan/$chat_id.txt",'Uz');
bot('sendMessage',[
    'chat_id'=> $chat_id,
    'text'=>"Assalomu alaykum! 
Hurmatli \"Yil volontyori\" tanlovi ishtirokchisi siz ushbu bot orqali o'zingiz faoliyatingizga oid faylni yuklab olib undagi barcha savollarga javob bergan holda ushbu botga jo'natishingiz so'raladi!

⭕️Eslatma❗️❗️❗️
https://t.me/yoshlaragentligi
Kanaliga azo bo'lmasangiz arizangiz qabul qilinmaydi iltimos azolikni tekshirib ariza jo'nating"
    ]);
    }else{
file_put_contents("lan/$chat_id.txt",'Ru');
bot('sendMessage',[
    'chat_id'=> $chat_id,
    'text'=>"Здравствуйте!
Уважаемый участник конкурса \"Волонтёр года\", Вам необходимо будет скачать файл-анкету, ответить на все вопросы и отправить на этот бот.

⭕️Примечание❗️❗️❗️
https://t.me/yoshlaragentligi
Если вы не являетесь участником канала, ваша заявка не будет принята. Проверьте свое членство и отправьте заявку."
    ]);
    }
    
  }elseif(file_get_contents("step/$chat_id.step") == 'doc'){
    switch($lan){
      case "Анкета участника 📄": $doc = "AnketaShaxsiyRu.xdoc"; break;
      case "Командная анкета 📄": $doc = "AnketaJamoviyRu.xdoc"; break;
      case "Shaxsiy anketa📄": $doc = "AnketaShaxsiyUz.xdoc"; break;
      case "Jamoaviy anketa📄": $doc = "AnketaJamoviyUz.xdoc"; break;
    }
    bot("senddocument",[
"chat_id"=>$message->chat->id,
"document"=>$doc
]);
file_put_contents("step/$chat_id.step","answer");
  }elseif(file_get_contents("step/$chat_id.step") == 'answer'){
  bot('forwardMessage', [
'chat_id'=>$admin,
'from_chat_id'=>$chat_id,
'message_id'=>$mid]);
  }
}
