<?php

namespace App\Repositories\Event;

use App\Jobs\JobMailCreditoEstado;
use App\Jobs\JobSMS;
use App\Models\Evento;
use App\Repositories\Contracts\RepositoriesInterface;
use App\Repositories\Eloquent\AbstractEloquentRepositories;
use App\Repositories\Eloquent\CreditoRepository as Credito;
use App\Repositories\Eloquent\EmpresaRepository;
use App\Repositories\Event\ShipableSMS;
use Str;

class CreditoEvent extends AbstractEloquentRepositories implements RepositoriesInterface
{

    public function __construct(Evento $evento = null)
    {
        if ($evento == null) {
            $evento = new Evento();
        }
        $this->model = $evento;
        $this->orderBy = "id";
    }

    public static function concedido(int $credito_id){
        $self = (new static);
        $evento = $self->findOneBy("codigo","credito::concedido");
        $credito = Credito::resolve()->with(["cliente:id,nome,email_principal,telefone_principal"])->findOneById($credito_id);
        $empresa = EmpresaRepository::resolve()->findOneById(1);
        if ($evento->email) {
            $evento->assunto = Str::replace('$codigo', $credito->codigo, $evento->assunto);
            $evento->mensagem_email = Str::replace('$nome', $credito->cliente->nome, $evento->mensagem_email);
            $evento->mensagem_email = Str::replace('$codigo', $credito->codigo, $evento->mensagem_email);
            $evento->mensagem_email = Str::replace('$empresa',$empresa->nome,$evento->mensagem_email);
            JobMailCreditoEstado::dispatch($credito->cliente->email_principal,$evento->mensagem_email);
        }
        if ($evento->sms) {
            $evento->mensagem_sms = Str::replace('$nome', $credito->cliente->nome, $evento->mensagem_sms);
            $evento->mensagem_sms = Str::replace('$codigo', $credito->codigo, $evento->mensagem_sms);
            $evento->mensagem_sms = Str::replace('$empresa',$empresa->nome,$evento->mensagem_sms);
            JobSMS::dispatch($credito->cliente->telefone_principal,$evento->mensagem_sms);
        }

    }


    public static function getMessage():string{
        return "";
    }

}
