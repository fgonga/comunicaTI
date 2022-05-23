<?php

namespace App\Tenant;

class ManagerTenant
{
    public  function getTenantIdentify(): int
    {
        return auth()->user()->tenant_id;
    }
}
