<?php

namespace App\Repositories\Event;

use App\Jobs\JobMailSolicitacaoEstado;
use App\Jobs\JobSMS;
use App\Models\Evento;
use App\Repositories\Contracts\RepositoriesInterface;
use App\Repositories\Eloquent\AbstractEloquentRepositories;
use App\Repositories\Eloquent\EmpresaRepository;
use App\Repositories\Eloquent\FaturaPrestacaoRepository;
use App\Repositories\Event\ShipableSMS;
use Str;

class PrestacaoEvent extends AbstractEloquentRepositories implements RepositoriesInterface
{

	public function __construct(Evento $evento = null)
	{
		if ($evento == null) {
			$evento = new Evento();
		}
		$this->model = $evento;
		$this->orderBy = "id";
	}

	public static function disponivel($fatura_prestacao_id){
		$self = (new static);
		$evento = $self->findOneBy("codigo","prestacao::disponivel");
		$empresa = EmpresaRepository::resolve()->findOneById(1);
		$fatura_prestacao = FaturaPrestacaoRepository::resolve()->columns(["id","codigo",'descricao',"encargos","cliente_id"])->with(["cliente:id,nome,email_principal,telefone_principal"])->findOneById($fatura_prestacao_id);


		if ($evento->email) {
			$evento->assunto = Str::replace('$codigo',$fatura_prestacao->codigo, $evento->assunto);
			$evento->mensagem_email = Str::replace('$nome',$fatura_prestacao->cliente->nome, $evento->mensagem_email);
			$evento->mensagem_email = Str::replace('$codigo',$fatura_prestacao->codigo, $evento->mensagem_email);
			$evento->mensagem_email = Str::replace('$descricao',$fatura_prestacao->descricao, $evento->mensagem_email);
			$evento->mensagem_email = Str::replace('$encargos',$fatura_prestacao->encargos, $evento->mensagem_email);
			$evento->mensagem_email = Str::replace('$empresa',$empresa->nome, $evento->mensagem_email);
			JobMailSolicitacaoEstado::dispatch($fatura_prestacao->cliente->email_principal,$evento->mensagem_email)->delay(now()->addHours(8));
		}
		if ($evento->sms) {
			$evento->mensagem_sms = Str::replace('$nome',$fatura_prestacao->cliente->nome, $evento->mensagem_sms);
			$evento->mensagem_sms = Str::replace('$codigo',$fatura_prestacao->codigo, $evento->mensagem_sms);
			$evento->mensagem_sms = Str::replace('$descricao',$fatura_prestacao->descricao, $evento->mensagem_sms);
			$evento->mensagem_sms = Str::replace('$encargos',$fatura_prestacao->encargos, $evento->mensagem_sms);
			$evento->mensagem_sms = Str::replace('$empresa',$empresa->nome, $evento->mensagem_sms);
			JobSMS::dispatch($fatura_prestacao->cliente->telefone_principal,$evento->mensagem_sms)->delay(now()->addHours(8));;
		}

	}


	public static function getMessage():string{
		return "";
	}

}
