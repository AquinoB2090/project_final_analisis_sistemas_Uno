<?php

namespace Tests\Feature;

use App\Models\CitaMedica;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CitaMedicaApiTest extends TestCase
{
    use RefreshDatabase;

    private Tenant $tenant;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        config(['jwt.secret' => 'testing-secret']);

        $this->tenant = Tenant::factory()->create();
        $this->user = User::factory()->create([
            'tenant_id' => $this->tenant->id,
        ]);
    }

    public function test_user_can_create_cita_medica(): void
    {
        $response = $this->withAuthHeaders()->postJson('/api/v1/citas-medicas', [
            'fecha' => '2026-07-01 09:30:00',
            'paciente' => 'Ana Lopez',
            'responsable' => 'Dr. Carlos Perez',
            'estado' => 'pendiente',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.paciente', 'Ana Lopez')
            ->assertJsonPath('data.responsable', 'Dr. Carlos Perez')
            ->assertJsonPath('data.estado', 'pendiente');

        $this->assertDatabaseHas('citas_medicas', [
            'tenant_id' => $this->tenant->id,
            'paciente' => 'Ana Lopez',
            'responsable' => 'Dr. Carlos Perez',
            'estado' => 'pendiente',
        ]);
    }

    public function test_user_can_list_show_update_and_delete_cita_medica(): void
    {
        $cita = CitaMedica::factory()->create([
            'tenant_id' => $this->tenant->id,
            'paciente' => 'Luis Garcia',
            'responsable' => 'Dra. Maria Ruiz',
            'estado' => 'confirmada',
        ]);

        $this->withAuthHeaders()
            ->getJson('/api/v1/citas-medicas')
            ->assertOk()
            ->assertJsonPath('data.0.id', $cita->id);

        $this->withAuthHeaders()
            ->getJson("/api/v1/citas-medicas/{$cita->id}")
            ->assertOk()
            ->assertJsonPath('data.paciente', 'Luis Garcia');

        $this->withAuthHeaders()->putJson("/api/v1/citas-medicas/{$cita->id}", [
            'fecha' => '2026-07-03 11:00:00',
            'paciente' => 'Luis Garcia',
            'responsable' => 'Dr. Roberto Diaz',
            'estado' => 'atendida',
        ])->assertOk()
            ->assertJsonPath('data.responsable', 'Dr. Roberto Diaz')
            ->assertJsonPath('data.estado', 'atendida');

        $this->withAuthHeaders()
            ->deleteJson("/api/v1/citas-medicas/{$cita->id}")
            ->assertOk();

        $this->assertDatabaseMissing('citas_medicas', [
            'id' => $cita->id,
        ]);
    }

    public function test_cita_medica_requires_valid_fields(): void
    {
        $this->withAuthHeaders()->postJson('/api/v1/citas-medicas', [
            'fecha' => 'no-es-fecha',
            'paciente' => '',
            'responsable' => '',
            'estado' => 'desconocido',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors([
                'fecha',
                'paciente',
                'responsable',
                'estado',
            ]);
    }

    public function test_user_cannot_access_cita_medica_from_another_tenant(): void
    {
        $otherTenant = Tenant::factory()->create();
        $cita = CitaMedica::factory()->create([
            'tenant_id' => $otherTenant->id,
        ]);

        $this->withAuthHeaders()
            ->getJson("/api/v1/citas-medicas/{$cita->id}")
            ->assertNotFound();
    }

    private function withAuthHeaders(): self
    {
        $token = JWTAuth::fromUser($this->user);

        return $this->withHeaders([
            'Authorization' => "Bearer {$token}",
            'X-Tenant-ID' => $this->tenant->id,
        ]);
    }
}
