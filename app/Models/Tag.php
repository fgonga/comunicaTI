<?php
namespace App\Models;
use App\Tenant\ManagerTenant;
use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property integer $tenant_id
 * @property string $nome
 * @property string $created_at
 * @property string $updated_at
 * @property Tenant $tenant
 */
class Tag extends Model
{
    use TenantTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tag';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['tenant_id', 'nome', 'created_at', 'updated_at'];

    protected $hidden = [
        'tenant_id',
    ];
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

    /**
     * @return BelongsToMany
     */
    public function contacts(): BelongsToMany
    {
        return $this
            ->belongsToMany(Contact::class, 'tag_in_contact', 'tag_id', 'contact_id')
            ->withoutGlobalScopes()
            ->where('contact.tenant_id',(new ManagerTenant)->getTenantIdentify())
            ->withPivot('tenant_id');

    }
}
