<?php

namespace App\Repositories\Event;
use App\Jobs\JobMailSolicitacaoEstado;
use App\Jobs\JobSMS;
use App\Models\Evento;
use App\Repositories\Contracts\RepositoriesInterface;
use App\Repositories\Eloquent\AbstractEloquentRepositories;
use App\Repositories\Eloquent\EmpresaRepository;
use App\Repositories\Eloquent\SolicitacaoRepository as Solicitacao;
use Str;

class SolicitacaoEvent extends AbstractEloquentRepositories implements RepositoriesInterface
{

    protected $solicitacao =null;
    protected $empresa =null;
    public function __construct(Evento $evento = null)
    {
        if ($evento == null) {
            $evento = new Evento();
        }
        $this->model = $evento;
        $this->orderBy = "id";
        $this->empresa = EmpresaRepository::resolve()->findOneById(1);
    }
    public function resolve(int $solicitacao_id, string $evento){
        $this->model = $this->findOneBy("codigo",$evento);
        $this->solicitacao = Solicitacao::resolve()
            ->columns(["id","codigo","cliente_id"])
            ->with(["cliente:id,nome,email_principal,telefone_principal"])
            ->findOneById($solicitacao_id);
        $this->send();
    }
    public function replace_sms(){
        $this->model->mensagem_sms = Str::replace('$nome', $this->solicitacao->cliente->nome, $this->model->mensagem_sms);
        $this->model->mensagem_sms = Str::replace('$codigo', $this->solicitacao->codigo, $this->model->mensagem_sms);
        $this->model->mensagem_sms = Str::replace('$empresa',$this->empresa->nome,$this->model->mensagem_sms);
        return $this->model->mensagem_sms;
    }
    public function replace_email(){
        $this->model->mensagem_email = Str::replace('$nome', $this->solicitacao->cliente->nome, $this->model->mensagem_email);
        $this->model->mensagem_email = Str::replace('$codigo', $this->solicitacao->codigo, $this->model->mensagem_email);
        $this->model->mensagem_email = Str::replace('$empresa',$this->empresa->nome,$this->model->mensagem_email);
        return $this->model->mensagem_email;
    }
    public function send(){
        if ($this->model->sms) {
            JobSMS::dispatch($this->solicitacao->cliente->telefone_principal,$this->replace_sms());
        }
        if ($this->model->email) {
            JobMailSolicitacaoEstado::dispatch($this->solicitacao->cliente->email_principal,$this->replace_email());
        }
    }

}
