<?php
/*
** @httd1 - t.me/httd1 (Telegram)
** https://github.com/httd1
*
** Bot Markdown simples. (https://github.com/httd1/simplebotmarkdown)
*
*/

include 'func.class.php';

define ('TOKEN','<TOKEN_TELEGRAM>');

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
		
$texto=$tlg->text ();
$username=$tlg->username ();
$nome=$tlg->name ();
$chatID=$tlg->chat_id ();

switch ($texto):

case '/start':

$tlg->APITelegram ('sendMessage', [
'chat_id' => $chatID,
'text' => "Olá <b>{$nome}</b> !

✍ Formate suas mensagens em Links, Código, Itálico, Negrito...

[Texto do Link](http://seulink.com)

`Marcação de Código`

```Marcação Código em Bloco```

_Marcação em Itálico_

*Marcação em Negrito*
",
'parse_mode' => 'html',
'disable_web_page_preview' => 'true'
]);

break;
case '/ajuda':
case '/help':

$tlg->APITelegram ('sendMessage',[
'chat_id' => $chatID,
'text' => 'Texto de ajuda!'
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
		'text' => 'Há um erro na formatação da sua mensagem'
		]);
		
		}

endswitch;

?>