<template>
    <section class="appointments">
        <header class="appointments__header">
            <div>
                <h1 class="appointments__title">
                    Citas medicas
                </h1>
                <p class="appointments__subtitle">
                    Tenant activo: {{ auth.tenantId }}
                </p>
            </div>
            <button class="appointments__secondary" type="button" @click="fetchCitas">
                Actualizar
            </button>
        </header>

        <p v-if="message" class="appointments__message" :class="{ 'appointments__message--error': hasError }">
            {{ message }}
        </p>

        <form class="appointment-form" @submit.prevent="saveCita">
            <input
                v-model="form.fecha"
                class="appointment-form__input"
                type="datetime-local"
                required
            >
            <input
                v-model="form.paciente"
                class="appointment-form__input"
                type="text"
                placeholder="Paciente"
                required
            >
            <input
                v-model="form.responsable"
                class="appointment-form__input"
                type="text"
                placeholder="Responsable"
                required
            >
            <select v-model="form.estado" class="appointment-form__input" required>
                <option v-for="estado in estados" :key="estado" :value="estado">
                    {{ estado }}
                </option>
            </select>
            <div class="appointment-form__actions">
                <button class="appointments__primary" type="submit" :disabled="saving">
                    {{ saving ? 'Guardando...' : editingId ? 'Actualizar cita' : 'Crear cita' }}
                </button>
                <button
                    v-if="editingId"
                    class="appointments__secondary"
                    type="button"
                    @click="resetForm"
                >
                    Cancelar
                </button>
            </div>
        </form>

        <div class="appointments__table-wrap">
            <table class="appointments__table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Paciente</th>
                        <th>Responsable</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="loading">
                        <td colspan="5">
                            Cargando citas...
                        </td>
                    </tr>
                    <tr v-else-if="citas.length === 0">
                        <td colspan="5">
                            No hay citas registradas.
                        </td>
                    </tr>
                    <tr v-for="cita in citas" v-else :key="cita.id">
                        <td>{{ formatDate(cita.fecha) }}</td>
                        <td>{{ cita.paciente }}</td>
                        <td>{{ cita.responsable }}</td>
                        <td>
                            <span class="appointments__status">
                                {{ cita.estado }}
                            </span>
                        </td>
                        <td class="appointments__row-actions">
                            <button class="appointments__secondary" type="button" @click="editCita(cita)">
                                Editar
                            </button>
                            <button class="appointments__danger" type="button" @click="deleteCita(cita)">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import api from '@/plugins/axios';
import { useAuthStore } from '@/stores/auth';

const auth = useAuthStore();
const demoTenantId = '00000000-0000-4000-8000-000000000001';
const estados = ['pendiente', 'confirmada', 'cancelada', 'atendida'];
const citas = ref([]);
const loading = ref(false);
const saving = ref(false);
const editingId = ref(null);
const message = ref('');
const hasError = ref(false);

const emptyForm = {
    fecha: '',
    paciente: '',
    responsable: '',
    estado: 'pendiente',
};

const form = reactive({ ...emptyForm });

onMounted(() => {
    ensureTenant();
    fetchCitas();
});

function ensureTenant() {
    if (! auth.tenantId) {
        auth.setTenantId(demoTenantId);
    }
}

async function fetchCitas() {
    loading.value = true;
    clearMessage();

    try {
        const { data } = await api.get('/citas-medicas');
        citas.value = data.data ?? [];
    } catch (error) {
        showError(error, 'No fue posible cargar las citas.');
    } finally {
        loading.value = false;
    }
}

async function saveCita() {
    saving.value = true;
    clearMessage();

    try {
        const payload = {
            fecha: normalizeDateForApi(form.fecha),
            paciente: form.paciente,
            responsable: form.responsable,
            estado: form.estado,
        };

        if (editingId.value) {
            await api.put(`/citas-medicas/${editingId.value}`, payload);
            showMessage('Cita actualizada correctamente.');
        } else {
            await api.post('/citas-medicas', payload);
            showMessage('Cita creada correctamente.');
        }

        resetForm();
        await fetchCitas();
    } catch (error) {
        showError(error, 'No fue posible guardar la cita.');
    } finally {
        saving.value = false;
    }
}

function editCita(cita) {
    editingId.value = cita.id;
    form.fecha = toDatetimeLocal(cita.fecha);
    form.paciente = cita.paciente;
    form.responsable = cita.responsable;
    form.estado = cita.estado;
    clearMessage();
}

async function deleteCita(cita) {
    const confirmed = window.confirm(`Eliminar la cita de ${cita.paciente}?`);

    if (! confirmed) {
        return;
    }

    clearMessage();

    try {
        await api.delete(`/citas-medicas/${cita.id}`);
        showMessage('Cita eliminada correctamente.');
        await fetchCitas();
    } catch (error) {
        showError(error, 'No fue posible eliminar la cita.');
    }
}

function resetForm() {
    editingId.value = null;
    Object.assign(form, emptyForm);
}

function normalizeDateForApi(value) {
    return value ? value.replace('T', ' ') + ':00' : '';
}

function toDatetimeLocal(value) {
    if (! value) {
        return '';
    }

    return value.slice(0, 16);
}

function formatDate(value) {
    if (! value) {
        return '';
    }

    return new Intl.DateTimeFormat('es-GT', {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(new Date(value));
}

function showMessage(text) {
    message.value = text;
    hasError.value = false;
}

function showError(error, fallback) {
    const errors = error?.response?.data?.errors;
    const firstValidationError = errors ? Object.values(errors)?.[0]?.[0] : null;

    message.value = firstValidationError ?? error?.response?.data?.message ?? fallback;
    hasError.value = true;
}

function clearMessage() {
    message.value = '';
    hasError.value = false;
}
</script>

<style scoped>
.appointments {
    max-width: 1120px;
    margin: 0 auto;
}

.appointments__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1rem;
}

.appointments__title {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
}

.appointments__subtitle {
    margin: 0.25rem 0 0;
    color: #475569;
}

.appointments__message {
    border: 1px solid #bbf7d0;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    margin-bottom: 1rem;
    color: #166534;
    background: #f0fdf4;
}

.appointments__message--error {
    border-color: #fecaca;
    color: #991b1b;
    background: #fef2f2;
}

.appointment-form {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 0.75rem;
    padding: 1rem;
    margin-bottom: 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background: #ffffff;
}

.appointment-form__input {
    min-width: 0;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    padding: 0.65rem 0.75rem;
    font-size: 0.95rem;
    background: #ffffff;
}

.appointment-form__actions {
    grid-column: 1 / -1;
    display: flex;
    gap: 0.5rem;
}

.appointments__table-wrap {
    overflow-x: auto;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background: #ffffff;
}

.appointments__table {
    width: 100%;
    border-collapse: collapse;
}

.appointments__table th,
.appointments__table td {
    padding: 0.8rem 1rem;
    border-bottom: 1px solid #e2e8f0;
    text-align: left;
    vertical-align: middle;
}

.appointments__table th {
    font-size: 0.8rem;
    text-transform: uppercase;
    color: #475569;
    background: #f8fafc;
}

.appointments__table tr:last-child td {
    border-bottom: 0;
}

.appointments__status {
    display: inline-flex;
    align-items: center;
    min-height: 1.75rem;
    padding: 0.25rem 0.6rem;
    border-radius: 999px;
    background: #eef2ff;
    color: #3730a3;
    font-size: 0.85rem;
    font-weight: 600;
}

.appointments__row-actions {
    display: flex;
    gap: 0.5rem;
}

.appointments__primary,
.appointments__secondary,
.appointments__danger {
    border: 0;
    border-radius: 6px;
    padding: 0.6rem 0.8rem;
    font-weight: 600;
    cursor: pointer;
}

.appointments__primary {
    background: #2563eb;
    color: #ffffff;
}

.appointments__secondary {
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #0f172a;
}

.appointments__danger {
    background: #dc2626;
    color: #ffffff;
}

.appointments__primary:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}

@media (max-width: 860px) {
    .appointment-form {
        grid-template-columns: 1fr;
    }

    .appointments__header {
        align-items: flex-start;
        flex-direction: column;
    }
}
</style>
