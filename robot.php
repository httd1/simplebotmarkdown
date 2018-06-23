<?php

/*
** @httd1 - t.me/httd1 (Telegram)
** https://github.com/httd1
*
** Bot Markdown simples. (https://github.com/httd1/simplebotmarkdown)
*
*/

include 'func.class.php';

define ('TOKEN','<TOKEN_BOT>');
define ('USER_BOT','@robot');

$tlg=new Tlg (TOKEN);

	if (empty ($tlg->data ())){
		
		// Somente urls em https
		$url='https://'.$_SERVER ['HTTP_HOST'].$_SERVER ['REQUEST_URI'];
		
		$ret=$tlg->APITelegram ('setWebhook', [
		'url' => $url
		]);
		
		if ($ret->ok){
			
			echo 'Ok,url de Webhook definida para '.$url;
			}else {
				echo 'Ops! Houve um erro ao definir url de Webhook.
ERRO: '.$ret->error_code.' DESCRIPTION: '.$ret->description;
				}
				
		exit ();
		
		}
		
$texto = $tlg->text ();
$username = $tlg->username ();
$nome = $tlg->name ();
$chatID = $tlg->chat_id ();
$pref = ($tlg->lang () != 'en' && $tlg->lang () != 'es' && $tlg->lang () != 'pt') ? 'en' : $tlg->lang ();

// Textos em várias línguas
include 'idiomas.php';

	// Resposta Inline
	
	if (isset ($tlg->data ()->inline_query)){

	$build = [[
	'type' => 'article',
	'id' => '0',
	'title' => USER_BOT,
	'description' => $tlg->data ()->inline_query->query,
	'input_message_content' => [
	'message_text' => $tlg->data ()->inline_query->query,
	'parse_mode' => 'markdown'
	]
	]];

	$query = [
	'inline_query_id' =>  $tlg->data ()->inline_query->id,
	'results' => json_encode($build)
	];
	
	$tlg->APITelegram ('answerInlineQuery', $query);
		
			exit;
		}
		

switch ($texto):

case '/start':

$tlg->APITelegram ('sendMessage', [
'chat_id' => $chatID,
'text' => $lang [$pref]['start'],
'parse_mode' => 'html',
'disable_web_page_preview' => 'true'
]);

break;
case '/ajuda':
case '/help':

$tlg->APITelegram ('sendMessage',[
'chat_id' => $chatID,
'text' => $lang [$pref]['help']
]);

break;
default:

// Envia texto estilizado com markdown.

$send=$tlg->APITelegram ('sendMessage', [
'chat_id' => $chatID,
'text' => $texto,
'parse_mode' => 'markdown',
'disable_web_page_preview' => 'true'
]);

	if (!$send->ok){
		
		$tlg->APITelegram ('sendMessage', [
		'chat_id' => $chatID,
		'text' => $lang [$pref]['erro']
		]);
		
		}

endswitch;

?>