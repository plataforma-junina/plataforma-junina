<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TeamPermissionGroup;
use Carbon\CarbonInterface;
use Database\Factories\PermissionGroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read TeamPermissionGroup $name
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
final class PermissionGroup extends Model
{
    /** @use HasFactory<PermissionGroupFactory> */
    use HasFactory;

    /**
     * @return HasMany<Permission, $this>
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'name' => TeamPermissionGroup::class,
        ];
    }
}
