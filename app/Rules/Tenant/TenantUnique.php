<?php

namespace App\Rules\Tenant;

use App\Tenant\ManagerTenant;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class TenantUnique implements Rule
{
    public string $table;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $tenant = app(ManagerTenant::class)->getTenantIdentify();
        $result =  DB::table($this->table)
            ->where($attribute, $value)
            ->where('tenant_id',$tenant)
            ->first();

        return is_null($result);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'O valor para o campo :attribute já está sendo utilizado.';
    }
}
