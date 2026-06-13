<?php

namespace App\Models;

use Database\Factories\CitaMedicaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CitaMedica extends Model
{
    /** @use HasFactory<CitaMedicaFactory> */
    use HasFactory;

    protected $table = 'citas_medicas';

    public const ESTADOS = [
        'pendiente',
        'confirmada',
        'cancelada',
        'atendida',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'fecha',
        'paciente',
        'responsable',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }
}
