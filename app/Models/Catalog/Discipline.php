<?php

namespace App\Models\Catalog;

use App\Models\File\File;
use App\Models\Shop\Consultation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $data)
 * @property mixed is_active
 * @property File image
 * @property File picto
 */
class Discipline extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'image_id',
        'picto_id',
        'background_color',
    ];

    /**
     * The formations that belong to the discipline.
     *
     * @return BelongsToMany
     */
    public function formations(): BelongsToMany
    {
        return $this->belongsToMany(Formation::class, 'discipline_formation')
            ->using(DisciplineFormation::class)
            ->withTimestamps();
    }

    /**
     * Get image url attribute
     *
     * @return string
     */
    public function getImageUrlAttribute(): ?string
    {
        /**
         * @var File $image
         */
        $image = $this->image()->first();
        return $image ? url($image->path) : url('/img/icon/icon-1.svg');
    }

    /**
     * Get the image that owns the discipline.
     *
     * @return BelongsTo
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    /**
     * The consultations that belong to the discipline.
     *
     * @return HasMany
     */
    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class, 'discipline_id');
    }

    /**
     * The experts that belong to the discipline.
     *
     * @return BelongsToMany
     */
    public function experts(): BelongsToMany
    {
        return $this->users()
            ->where('users.role', '=', User\Expert::ROLE);
    }

    /**
     * Get the picto that owns the discipline.
     *
     * @return BelongsTo
     */
    public function picto(): BelongsTo
    {
        return $this->belongsTo(File::class, 'picto_id');
    }

    /**
     * The users that belong to the discipline.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'discipline_user')
            ->using(User\DisciplineUser::class)
            ->withPivot('durations')
            ->withPivot('with_preparation')
            ->withTimestamps();
    }
}
