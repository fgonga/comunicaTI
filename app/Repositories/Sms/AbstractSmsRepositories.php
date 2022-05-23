<?php
/*
 * Copyright (c) 2021. por Datalog, Lda Todos os direitos reservados.
 *  Nenhuma parte deste programa pode ser reproduzida, distribuída ou transmitida de qualquer forma ou por qualquer meio, incluindo fotocópia,
 * gravação ou outros métodos eletrônicos ou mecânicos, sem a permissão prévia por escrito da  Datalog, Lda , exceto no caso de breves
 * citações incorporadas em análises críticas e outros usos não comerciais permitidos pela lei de direitos autorais.
 */

namespace App\Repositories\Sms;
use App\Repositories\Contracts\SmsRepositoriesInterface;
use Illuminate\Support\Facades\Http;

abstract class AbstractSmsRepositories implements SmsRepositoriesInterface {

    protected $url ="";
    protected $token="";
    protected $recipients = [];
    protected $sender = "Datagest";
    protected $message="";

    public function __construct() {
        $this->url = config("sms.SMS_API_URL");
        $this->token = config("sms.SMS_API_TOKEN");
        $this->sender = config("sms.SMS_API_SENDER");
        $this->url = "$this->url?token=$this->token";
    }
    public function recipients(array $recipients)
    {
        $this->recipients = [];
        foreach ($recipients as $recipient){
            $this->recipients[] =["msisdn" =>$recipient];
        }
        return $this;
    }

    public function sender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    public function message($message)
    {
        $this->message = $message;
        return $this;
    }
    public  function toJson() {

    }
    public function send()
    {
        return Http::withHeaders([
            "Content-Type"=>"application/json",
        ])->post($this->url,[
            'sender' => $this->sender,
            'message' => $this->message,
            'recipients' => $this->recipients,
            'encoding' => 'UCS2'
        ])->body();
    }
}
