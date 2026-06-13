<?php

namespace Database\Factories;

use App\Models\CitaMedica;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CitaMedica>
 */
class CitaMedicaFactory extends Factory
{
    protected $model = CitaMedica::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'fecha' => fake()->dateTimeBetween('now', '+1 month'),
            'paciente' => fake()->name(),
            'responsable' => fake()->name(),
            'estado' => fake()->randomElement(CitaMedica::ESTADOS),
        ];
    }
}
