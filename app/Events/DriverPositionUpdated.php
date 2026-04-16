<?php

namespace App\Events;

use App\Models\Demande;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DriverPositionUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Demande $demande;
    public array $position;

    public function __construct(Demande $demande, array $position)
    {
        $this->demande = $demande;
        $this->position = $position;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('tracking.demande.' . $this->demande->id);
    }

    public function broadcastAs(): string
    {
        return 'DriverPositionUpdated';
    }

    public function broadcastWith(): array
    {
        return [
            'lat' => $this->position['lat'],
            'lng' => $this->position['lng'],
            'time' => $this->position['time'] ?? now()->format('d/m/Y H:i:s'),
            'demande_id' => $this->demande->id,
        ];
    }
}
