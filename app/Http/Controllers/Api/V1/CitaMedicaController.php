<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CitaMedica;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CitaMedicaController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tenant = $this->tenant($request);

        $citas = CitaMedica::query()
            ->where('tenant_id', $tenant->id)
            ->latest('fecha')
            ->get();

        return response()->json([
            'data' => $citas,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $tenant = $this->tenant($request);

        $validated = $this->validateCita($request);

        $cita = CitaMedica::query()->create([
            ...$validated,
            'tenant_id' => $tenant->id,
        ]);

        return response()->json([
            'message' => 'Cita medica creada correctamente.',
            'data' => $cita,
        ], 201);
    }

    public function show(Request $request, CitaMedica $cita_medica): JsonResponse
    {
        $this->abortIfCitaDoesNotBelongToTenant($request, $cita_medica);

        return response()->json([
            'data' => $cita_medica,
        ]);
    }

    public function update(Request $request, CitaMedica $cita_medica): JsonResponse
    {
        $this->abortIfCitaDoesNotBelongToTenant($request, $cita_medica);

        $cita_medica->update($this->validateCita($request));

        return response()->json([
            'message' => 'Cita medica actualizada correctamente.',
            'data' => $cita_medica->refresh(),
        ]);
    }

    public function destroy(Request $request, CitaMedica $cita_medica): JsonResponse
    {
        $this->abortIfCitaDoesNotBelongToTenant($request, $cita_medica);

        $cita_medica->delete();

        return response()->json([
            'message' => 'Cita medica eliminada correctamente.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validateCita(Request $request): array
    {
        return $request->validate([
            'fecha' => ['required', 'date'],
            'paciente' => ['required', 'string', 'max:255'],
            'responsable' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'string', Rule::in(CitaMedica::ESTADOS)],
        ]);
    }

    private function abortIfCitaDoesNotBelongToTenant(Request $request, CitaMedica $cita_medica): void
    {
        $tenant = $this->tenant($request);

        abort_if((string) $cita_medica->tenant_id !== (string) $tenant->id, 404);
    }

    private function tenant(Request $request): Tenant
    {
        /** @var Tenant $tenant */
        $tenant = $request->attributes->get('tenant');

        return $tenant;
    }
}
