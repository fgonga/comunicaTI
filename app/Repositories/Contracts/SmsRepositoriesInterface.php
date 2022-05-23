<?php
/*
 * Copyright (c) 2021. por Datalog, Lda Todos os direitos reservados.
 *  Nenhuma parte deste programa pode ser reproduzida, distribuída ou transmitida de qualquer forma ou por qualquer meio, incluindo fotocópia,
 * gravação ou outros métodos eletrônicos ou mecânicos, sem a permissão prévia por escrito da  Datalog, Lda , exceto no caso de breves
 * citações incorporadas em análises críticas e outros usos não comerciais permitidos pela lei de direitos autorais.
 */

namespace App\Repositories\Contracts;

interface  SmsRepositoriesInterface
{

    /**
     *
     * @param array $recipients
     * @return $this
     */
    public function recipients(array $recipients);

    /**
     *
     * @param  $sender
     * @return $this
     */
    public function sender($sender);

    /**
     *
     * @param  $message
     * @return $this
     */
    public function message($message);


    /**
     * @return $this
     */
    public function send();



}
