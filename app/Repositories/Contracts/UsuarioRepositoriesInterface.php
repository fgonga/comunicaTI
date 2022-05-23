<?php
/*
 * Copyright (c) 2021. BantuSoft todos direitos reservados
 */

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories\Contracts;
use App\Models\User;

/**
 *
 * @author FG
 */
interface UsuarioRepositoriesInterface extends RepositoriesInterface {
   public function redifinir_senha(User $data, $newpassword);
   public function update(User $user, array $data);
}
