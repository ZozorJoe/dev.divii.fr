<?php

namespace App\Models\Shop;

use App\Events\Consultation\ConsultationCompleted;
use App\Events\Consultation\ConsultationValidated;
use App\Models\Catalog\Discipline;
use App\Models\Catalog\Duration;
use App\Models\Chat\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Class Consultation
 * @package App\Models\Shop
 *
 * @property string status
 * @property Carbon start_at
 * @property Carbon end_at
 * @property int expert_id
 * @property int duration_id
 * @property User\Expert expert
 * @property mixed customer_id
 * @property mixed|string name
 * @property User customer
 * @property Duration duration
 * @property mixed main_id
 * @property mixed discipline_id
 * @property mixed label
 * @property mixed children
 * @method static find($id)
 * @method static where(string $string, string $string1, $id)
 */
class Consultation extends Model
{
    use HasFactory;

    const STATUS_NEW = 'new';
    const STATUS_PROCESSING = 'processing';
    const STATUS_VALIDATED = 'validated';
    const STATUS_COMPLETE = 'complete';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->user_id && auth()->check()) {
                /** @var User $user */
                $user = auth()->user();
                $model->customer_id = $user->getKey();
            }
        });
    }

    /**
     * @param Room $room
     * @param Consultation $consultation1
     * @return Consultation
     */
    public static function associate(Room $room, Consultation $consultation1): Consultation
    {
        /** @var Consultation $consultation2 */
        $consultation2 = $room->model;
        if(is_null($consultation2->duration_id)){
            $main = $consultation2;
            $main->children()->save($consultation1);

            // Update main title
            $main->name = $main->label;
            $main->save();

            // Update room title
            $room->title = $main->label;
            $room->save();

            // Update start at
            $consultation2->start_at = $room->start_at;
            $consultation2->end_at = $room->end_at;
            $consultation2->save();

            return $consultation2;
        }

        if(is_null($consultation1->duration_id)){
            $main = $consultation1;
            $main->children()->save($consultation2);

            // Update main title
            $main->name = $main->label;
            $main->save();

            // Update room title
            $room->title = $main->label;
            $room->save();

            $consultation1->start_at = $room->start_at;
            $consultation1->end_at = $room->end_at;
            $consultation1->save();

            return $consultation1;
        }

        $main = new Consultation();
        $main->status = Consultation::STATUS_COMPLETE;
        $main->name = "Fusion";
        $main->expert_id = $room->user_id;
        $main->customer_id = $consultation1->customer_id;
        $main->duration_id = null;
        $main->main_id = null;
        $main->start_at = $room->start_at;
        $main->end_at = $room->end_at;
        $main->save();

        $main->children()->save($consultation1);
        $main->children()->save($consultation2);

        // Update main title
        $main->name = $main->label;
        $main->save();

        // Update room title
        $room->title = $main->label;
        $room->save();

        return $main;
    }

    /**
     * Get the children for the consultation.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Consultation::class, 'main_id');
    }

    /**
     * Mark as complete
     */
    public function complete()
    {
        $this->status = Consultation::STATUS_COMPLETE;
        $this->save();

        // Trigger event
        event(new ConsultationCompleted($this));
    }

    /**
     * Get the customer that owns the consultation.
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the discipline that owns the consultation.
     *
     * @return BelongsTo
     */
    public function discipline(): BelongsTo
    {
        return $this->belongsTo(Discipline::class, 'discipline_id');
    }

    /**
     * Get the duration that owns the consultation.
     *
     * @return BelongsTo
     */
    public function duration(): BelongsTo
    {
        return $this->belongsTo(Duration::class, 'duration_id');
    }

    /**
     * Get the customer that owns the consultation.
     *
     * @return BelongsTo
     */
    public function expert(): BelongsTo
    {
        return $this->belongsTo(User::class, 'expert_id');
    }

    /**
     * Get label
     */
    public function getLabelAttribute(): string
    {
        $label = "Consultation de ";
        if($this->duration){
            $label .= $this->duration->label;
            return $label;
        }
        $now = now();
        $date = $now->copy();
        foreach ($this->children as $child){
            info($child->duration_id);
            if($child->duration){
                $date->add($child->duration->delay);
            }
        }
        $duration = $date->diffInMinutes($now);
        $label .= $duration;
        return $label;
    }

    /**
     * Get the invoice items of the consultation.
     */
    public function invoiceItems(): MorphMany
    {
        return $this->morphMany(InvoiceItem::class, 'invoiceable');
    }

    /**
     * Get the main that owns the consultation.
     *
     * @return BelongsTo
     */
    public function main(): BelongsTo
    {
        return $this->belongsTo(Consultation::class, 'main_id');
    }

    /**
     * Get the consultation's room.
     */
    public function room(): MorphOne
    {
        return $this->morphOne(Room::class, 'model');
    }

    /**
     * Mark as validated
     */
    public function validate()
    {
        $this->status = Consultation::STATUS_VALIDATED;
        $this->save();

        // Trigger event
        event(new ConsultationValidated($this));
    }
}
