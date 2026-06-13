# Resumen del modulo de citas medicas

Este documento resume el trabajo realizado en el proyecto final para el modulo de citas medicas.

## Que se hizo

Se analizo la base del proyecto Laravel 12 + Vue 3 y se implemento un modulo CRUD para administrar citas medicas. El modulo permite crear, listar, consultar, actualizar y eliminar citas con los campos minimos solicitados:

- `fecha`
- `paciente`
- `responsable`
- `estado`

Los estados permitidos son:

- `pendiente`
- `confirmada`
- `cancelada`
- `atendida`

## Pantalla principal

La vista minima del CRUD esta disponible en:

```text
http://localhost:8000/
```

La pantalla permite usar el CRUD directamente, sin iniciar sesion. Para mantener la separacion por tenant, la vista usa automaticamente el tenant demo:

```text
00000000-0000-4000-8000-000000000001
```

## API del modulo

Las rutas principales del CRUD son:

```text
GET    /api/v1/citas-medicas
POST   /api/v1/citas-medicas
GET    /api/v1/citas-medicas/{cita_medica}
PUT    /api/v1/citas-medicas/{cita_medica}
PATCH  /api/v1/citas-medicas/{cita_medica}
DELETE /api/v1/citas-medicas/{cita_medica}
```

Las rutas requieren la cabecera:

```text
X-Tenant-ID: 00000000-0000-4000-8000-000000000001
```

## Archivos principales

- `app/Models/CitaMedica.php`
- `app/Http/Controllers/Api/V1/CitaMedicaController.php`
- `database/migrations/2026_06_13_000001_create_citas_medicas_table.php`
- `database/factories/CitaMedicaFactory.php`
- `routes/api.php`
- `resources/js/pages/HomePage.vue`
- `tests/Feature/CitaMedicaApiTest.php`

## Evidencia por sprint

- Sprint 1: `docs/evidencias/sprint-1.md`
- Sprint 2: `docs/evidencias/sprint-2.md`
- Sprint 3: `docs/evidencias/sprint-3.md`
- Guia de trazabilidad: `docs/evidencias/guia-trazabilidad.md`

## Diagramas UML

Los diagramas estan en formato PlantUML:

- `docs/uml/casos-uso-citas.puml`
- `docs/uml/clases-citas.puml`
- `docs/uml/secuencia-crear-actualizar-cita.puml`

## Verificacion aplicada

Durante el desarrollo se verifico:

- Creacion del archivo SQLite local.
- Ejecucion de migraciones.
- Ejecucion de seeders para tenant y usuario demo.
- Compilacion del frontend con `npm run build`.
- Pruebas del modulo con `php artisan test --filter=CitaMedicaApiTest`.
- Revision de rutas con `php artisan route:list --path=api/v1/citas-medicas`.
- Prueba manual del API sin token usando `X-Tenant-ID`.

## Como correrlo localmente

```text
composer install
npm install
php artisan key:generate
php artisan jwt:secret
New-Item -ItemType File -Path database\database.sqlite -Force
php artisan migrate --seed
npm run build
php artisan serve
```

Luego abrir:

```text
http://localhost:8000/
```
