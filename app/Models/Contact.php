<?php

namespace App\Models;

use App\Tenant\ManagerTenant;
use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property integer $id
 * @property integer $tenant_id
 * @property string $name
 * @property string $number
 * @property string $created_at
 * @property string $updated_at
 * @property Tenant $tenant
 * @property TagInContact[] $tagInContacts
 */
class Contact extends Model
{
    use TenantTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'tenant_id',
    ];
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['tenant_id', 'name', 'number', 'created_at', 'updated_at'];

    /**
     * @return BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
    /**
     * @return HasMany
     */
    public function tagInContacts(): HasMany
    {
        return $this->hasMany(TagInContact::class);
    }

    public function tags(): BelongsToMany
    {
        return $this
            ->belongsToMany(Tag::class, 'tag_in_contact', 'contact_id', 'tag_id')
            ->withoutGlobalScopes()
            ->where('tag.tenant_id',(new ManagerTenant)->getTenantIdentify())
            ->withPivot('tenant_id');
    }


}
