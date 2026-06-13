# Sprint 3: Diagramas UML

## Objetivo del sprint

Crear diagramas UML del modulo de citas medicas y verificar que representen el codigo real implementado en el Sprint 2.

## Prompt usado

```text
Sprint 3: Diagramas UML
- Crear diagrama de casos de uso.
- Crear diagrama de clases.
- Crear diagrama de secuencia para crear o actualizar cita.
- Verificar que los diagramas coincidan con el codigo real.
- Guardar diagramas en docs/uml/ o dentro de docs/evidencias/.
- Registrar evidencia en docs/evidencias/sprint-3.md.
- Hacer commit: docs: agregar diagramas UML del modulo de citas
```

## Objetivo del prompt

Documentar visualmente el modulo de citas medicas mediante diagramas UML versionables y alineados con rutas, controlador, modelos, middleware, migracion y pruebas existentes.

## Resumen de la respuesta recibida

Se reviso el codigo real del modulo de citas medicas y se crearon diagramas UML en formato PlantUML para casos de uso, clases y secuencia. La evidencia del sprint registra los archivos consultados, los diagramas generados y la verificacion aplicada.

## Decision humana tomada

Se decide guardar los diagramas en `docs/uml/` como archivos `.puml`, porque PlantUML permite mantener los diagramas en texto plano dentro del repositorio y facilita su actualizacion junto con el codigo.

## Diagramas creados

- `docs/uml/casos-uso-citas.puml`: representa las operaciones disponibles para el usuario del sistema sobre citas medicas.
- `docs/uml/clases-citas.puml`: representa controlador, modelo, tenant, usuario, middleware y tabla principal.
- `docs/uml/secuencia-crear-actualizar-cita.puml`: representa el flujo real para crear o actualizar una cita medica.

## Verificacion contra codigo real

Archivos revisados:

- `routes/api.php`
- `app/Http/Controllers/Api/V1/CitaMedicaController.php`
- `app/Models/CitaMedica.php`
- `app/Models/Tenant.php`
- `app/Models/User.php`
- `app/Http/Middleware/TenantMiddleware.php`
- `app/Http/Middleware/EnsureJwtTokenIsValid.php`
- `database/migrations/2026_06_13_000001_create_citas_medicas_table.php`
- `tests/Feature/CitaMedicaApiTest.php`

Correspondencia encontrada:

- Las rutas CRUD reales estan publicadas como recurso API `citas-medicas` bajo middleware `tenant`.
- El controlador real incluye acciones `index`, `store`, `show`, `update` y `destroy`.
- La creacion usa `CitaMedica::query()->create()` con los campos validados y el `tenant_id` tomado del request.
- La actualizacion valida pertenencia al tenant antes de ejecutar `update()` y devuelve el modelo refrescado.
- La tabla real `citas_medicas` contiene `tenant_id`, `fecha`, `paciente`, `responsable`, `estado` y timestamps.
- Los estados permitidos coinciden con la constante `CitaMedica::ESTADOS`: `pendiente`, `confirmada`, `cancelada` y `atendida`.
- Las pruebas feature cubren crear, listar, ver, actualizar, eliminar, validaciones y bloqueo de acceso entre tenants.

Nota de ajuste posterior:

- Los diagramas UML fueron revisados despues de habilitar la vista demo sin login.
- El flujo actual de citas usa tenant por cabecera `X-Tenant-ID`; el middleware JWT queda asociado a rutas de autenticacion, no al CRUD demo de citas.

## Verificacion aplicada

Comandos ejecutados:

```text
php artisan test --filter=CitaMedicaApiTest
git status --short
```

Resultado esperado:

- Los diagramas reflejan el comportamiento real del API de citas medicas.
- La prueba feature del modulo continua pasando.
- Los archivos nuevos de Sprint 3 quedan listos para commit sin modificar evidencia previa no relacionada.

## Commit asociado

```text
docs: agregar diagramas UML del modulo de citas
```
