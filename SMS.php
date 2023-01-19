<?php

class SMS 
{
    private static $apiKey = '7M4EUFETGQRTTMD2UI9DO9AHGXMS3H9IM39PI491EQCLZODTGGJUDGZOKR6XXNC3T0ICQN389LZOYOAXD5NGY866UGNFRL48RUYQBH1Q2JIB49LXWUEVVIAOH5SI88G0';
    private static $url = 'https://api.smsdev.com.br/v1/send';
    private static $type = 9; # TIPO SMS
    private $ch; # HANDLE SMS
    private $responseEnviar, $responseSituacao;

    public function __construct($mensagem, $numero)
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, self::$url);
        
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, 
        [
            'key'    => self::$apiKey
        ]);

        return true;
    }

    public function enviar($mensagem, $numero)
    {
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, 
        [
            'type'   => self::$type,
            'number' => $numero,
            'msg'    => $mensagem
        ]);

        $this->responseEnviar = json_decode(curl_exec($this->ch));

        return $this->responseEnviar;
    }

    public function situacao()
    {
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, 
        [
            'id' => $this->responseEnviar->id
        ]);

        $this->responseSituacao = json_decode(curl_exec($this->ch));

        return $this->responseSituacao->descricao.' | ENVIO: '.$this->responseSituacao->data_envio;
    }

}

