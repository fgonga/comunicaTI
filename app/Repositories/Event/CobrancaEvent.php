<?php

namespace App\Repositories\Event;
use App\Jobs\JobMailSolicitacaoEstado;
use App\Jobs\JobSMS;
use App\Models\Amortizacao;
use App\Models\Evento;
use App\Repositories\Contracts\RepositoriesInterface;
use App\Repositories\Eloquent\AbstractEloquentRepositories;
use App\Repositories\Eloquent\EmpresaRepository;

class CobrancaEvent extends AbstractEloquentRepositories implements RepositoriesInterface
{

    protected $amortizacao =null;
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
    public function resolve(int $amortizacao_id, string $evento){
        $this->model = $this->findOneBy("codigo",$evento);
        $this->amortizacao = Amortizacao::query()
            ->where("id",$amortizacao_id)->firstOrFail()->load(["credito:id,cliente_id","credito.cliente:id,nome,email_principal,telefone_principal"]);
        $this->send();
    }
    public function replace($str){
        return str_replace(
            ['$nome','$descricao','$encargos','$data','$empresa','$dias'],
            [
                $this->amortizacao->credito->cliente->nome,
                $this->amortizacao->descricao,
                $this->amortizacao->prestacao,
                $this->amortizacao->data,
                $this->empresa->nome,
                30
            ],
            $str);
    }
    public function replace_sms(){
        return $this->replace($this->model->mensagem_sms);
    }
    public function replace_email(){
        return $this->replace($this->model->mensagem_email);
    }
    public function send(){
        if ($this->model->sms) {
            JobSMS::dispatch($this->amortizacao->credito->cliente->telefone_principal,$this->replace_sms());
        }
        if ($this->model->email) {
            JobMailSolicitacaoEstado::dispatch($this->amortizacao->credito->cliente->email_principal,$this->replace_email());
        }
    }

}
