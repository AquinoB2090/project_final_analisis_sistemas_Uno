# Sprint 2: CRUD basico de citas medicas

## Objetivo del sprint

Implementar el CRUD basico de citas medicas con los campos minimos solicitados: fecha, paciente, responsable y estado.

## Prompt usado

```text
Sprint 2: CRUD basico de citas medicas
- Crear la migracion/modelo para citas medicas.
- Definir campos minimos: fecha, paciente, responsable y estado.
- Implementar rutas del API.
- Crear controlador con acciones: listar, crear, ver detalle, actualizar y eliminar.
- Agregar validaciones.
- Verificar endpoints o pruebas.
- Registrar evidencia en docs/evidencias/sprint-2.md.
- Hacer commits claros: feat agregar estructura de citas medicas; feat: implementar CRUD basico de citas medicas
```

## Objetivo del prompt

Agregar al proyecto el modulo funcional de citas medicas como API REST, manteniendo la arquitectura existente de Laravel, tenant por cabecera `X-Tenant-ID` y autenticacion JWT.

## Resumen de la respuesta recibida

Se implemento un CRUD basico para citas medicas. Primero se creo la estructura de datos del modulo y luego se agregaron rutas, controlador, validaciones, pruebas de endpoints y evidencia del sprint.

## Decision humana tomada

Se decide manejar `paciente` y `responsable` como campos de texto en este sprint para cumplir el alcance de CRUD basico sin crear modulos adicionales. Tambien se decide proteger el CRUD con `tenant` y `jwt.auth`, porque el proyecto ya usa tenant por cabecera y JWT en las rutas protegidas.

## Cambios realizados en el proyecto

- Se creo el modelo `App\Models\CitaMedica`.
- Se creo la migracion `citas_medicas`.
- Se creo una factory para citas medicas.
- Se agrego el controlador `App\Http\Controllers\Api\V1\CitaMedicaController`.
- Se agregaron rutas API REST en `routes/api.php`.
- Se agregaron validaciones para fecha, paciente, responsable y estado.
- Se agregaron pruebas feature para crear, listar, ver, actualizar, eliminar, validar campos y restringir acceso entre tenants.
- Se renombro el middleware JWT propio a `EnsureJwtTokenIsValid` para evitar una colision de autoload detectada durante la verificacion.
- Se creo esta evidencia en `docs/evidencias/sprint-2.md`.

## Campos implementados

- `fecha`: fecha y hora de la cita.
- `paciente`: nombre del paciente.
- `responsable`: nombre del responsable de la cita.
- `estado`: estado actual de la cita.

Estados permitidos:

- `pendiente`
- `confirmada`
- `cancelada`
- `atendida`

## Endpoints implementados

Todos los endpoints requieren:

- Header `X-Tenant-ID`.
- Header `Authorization: Bearer {token}`.

```text
GET    /api/v1/citas-medicas
POST   /api/v1/citas-medicas
GET    /api/v1/citas-medicas/{cita_medica}
PUT    /api/v1/citas-medicas/{cita_medica}
PATCH  /api/v1/citas-medicas/{cita_medica}
DELETE /api/v1/citas-medicas/{cita_medica}
```

## Verificacion aplicada

Comandos ejecutados:

```text
php -l app/Models/CitaMedica.php
php -l database/factories/CitaMedicaFactory.php
php -l database/migrations/2026_06_13_000001_create_citas_medicas_table.php
php -l app/Http/Controllers/Api/V1/CitaMedicaController.php
php -l tests/Feature/CitaMedicaApiTest.php
php artisan route:list --path=api/v1/citas-medicas
php artisan test --filter=CitaMedicaApiTest
npm install
npm run build
php artisan test
```

Resultado esperado:

- El modelo, factory y migracion no presentan errores de sintaxis.
- Las pruebas del CRUD validan endpoints principales y reglas de validacion.
- El acceso a citas de otro tenant devuelve 404.
- Resultado final de pruebas: `4 passed (21 assertions)`.
- Se creo `.env` local desde `.env.example` para evitar advertencias de PHPUnit por entorno no configurado. El archivo `.env` esta ignorado por Git.
- Se genero `APP_KEY` local para ejecutar la suite completa.
- Se ejecuto `npm install` y `npm run build` para generar el manifest de Vite requerido por el `ExampleTest` web. `node_modules` y `public/build` estan ignorados por Git.
- Resultado final de suite completa: `6 passed (23 assertions)`.

## Commits asociados

```text
feat: agregar estructura de citas medicas
feat: implementar CRUD basico de citas medicas
```
