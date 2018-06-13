<?php

/*
*
** @httd1 - t.me/httd1 (Telegram)
** 2018
*
*/

class Tlg {
	
	function __construct ($token){
		$this->tokenBot=$token;
		}
		
public function chat_id (){
	
	$chatID=$this->data ()->message->chat->id;
	return $chatID;
	
	}
	
public function username (){
	
	$username=@$this->data ()->message->from->username;
	return $username;
	
	}
	
public function name (){
	
	$nome=$this->data ()->message->from->first_name;
	return $nome;
	
	}
	
public function text (){
	
	$texto=$this->data ()->message->text;
	return $texto;
	
	}
	
public function data (){
	
	$data=file_get_contents ('php://input');
	$json=json_decode ($data);
	
		return $json;
	}
	
/*
*
** Seta uma URL de Webhook na API do Telegram.
*
** @param $url (string)
*
** @return Retorna um Objeto JSON.
*/
public function SetWebhook ($url){
	
	$url=strtolower (trim ($url));
	$api=$this->APITelegram ('setWebhook', [
	'url' => $url
	]);
	
	return json_decode ($api);
	
	}

/*
*
** Envia requisição POST para a API do Telegram.
 *
** @param $method (string)
** @param $param (array)
 *
** @return Retorna um Objeto JSON.
 *
*/
public function APITelegram ($method, $param){
	
	$query=$param;
	$api='https://api.telegram.org/bot'.$this->tokenBot.'/'.$method;
	
	$cURL=curl_init ($api);
	curl_setopt ($cURL, CURLOPT_POST,true);
	curl_setopt ($cURL, CURLOPT_POSTFIELDS, ($query));
	curl_setopt ($cURL, CURLOPT_RETURNTRANSFER,true);
	$ret=curl_exec ($cURL);
	curl_close ($cURL);
	
		return json_decode ($ret);
	}
	
		}