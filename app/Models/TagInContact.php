<?php

namespace App\Models;


use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id
 * @property integer $tenant_id
 * @property integer $contact_id
 * @property integer $tag_id
 * @property string $created_at
 * @property string $updated_at
 * @property Contact $contact
 * @property Tag $tag
 * @property Tenant $tenant
 */
class TagInContact extends Model
{
    use TenantTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tag_in_contact';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['tenant_id', 'contact_id', 'tag_id', 'created_at', 'updated_at'];
    protected $hidden = [
        'tenant_id',
    ];
    /**
     * @return BelongsTo
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo('App\Models\Contact');
    }

    /**
     * @return BelongsTo
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo('App\Models\Tag');
    }

    /**
     * @return BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo('App\Tenant');
    }
}
