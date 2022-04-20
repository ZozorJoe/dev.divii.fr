<?php

namespace App\Events\Consultation;

use App\Models\Shop\Consultation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConsultationValidated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Consultation
     */
    public $consultation;

    /**
     * ConsultationCompleted constructor.
     * @param Consultation $consultation
     */
    public function __construct(Consultation $consultation)
    {
        $this->consultation = $consultation;
    }
}
