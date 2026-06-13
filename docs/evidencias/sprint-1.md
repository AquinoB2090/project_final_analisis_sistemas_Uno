# Sprint 1: Analisis y base estructural

## Objetivo del sprint

Documentar el analisis inicial del proyecto y definir la base estructural del modulo asignado: citas medicas.

Este sprint no implementa todavia el CRUD. Su proposito es dejar evidencia de revision tecnica antes de programar, usando principalmente la informacion ya disponible en el README del proyecto y contrastandola con los archivos de dependencias.

## Prompt usado

```text
Sprint 1: Analisis y base estructural
en este sprint documentaremos el analisis para eso veremos en el readme del proyecto que ya esta la mayor parte de la informacion que necesitamos como la version de laravel, el framework e inclusive el stack
- Revisar la arquitectura actual del proyecto.
- Identificar framework, stack y dependencias principales.
- Definir el modulo asignado: citas medicas.
- Documentar entidades principales: cita medica, paciente, responsable y estado.
- Registrar la evidencia del sprint en docs/evidencias/sprint-1.md.
- Hacer commit con mensaje claro: docs: documentar analisis inicial del modulo de citas
```

## Objetivo del prompt

Crear una evidencia verificable del Sprint 1 donde se registre el analisis de arquitectura, framework, stack, dependencias y entidades base del modulo de citas medicas antes de iniciar la implementacion.

## Resumen de la respuesta recibida

Se reviso la documentacion principal del proyecto y los archivos de dependencias para identificar la arquitectura base. El proyecto ya incluye una estructura Laravel + Vue orientada a API REST y SPA, con autenticacion JWT, autorizacion por roles/permisos y soporte base de tenant por cabecera.

## Decision humana tomada

Se decide que el Sprint 1 sera solamente de analisis y base estructural. La implementacion del CRUD de citas medicas se dejara para el Sprint 2, con el fin de mantener evidencia progresiva y evitar que la entrega parezca realizada en una sola ejecucion.

## Analisis de arquitectura actual

El proyecto usa una arquitectura SPA + API REST:

- El backend esta construido con Laravel 12.
- El frontend esta construido con Vue 3 y Vite.
- Laravel expone respuestas JSON bajo rutas de API.
- Vue se monta desde una vista Blade base y usa Vue Router para manejar rutas del cliente.
- Axios se usa como cliente HTTP para comunicarse con el API.
- Las rutas web redirigen a la vista principal de la SPA.
- El API trabaja con tenant indicado por la cabecera `X-Tenant-ID`.
- Las rutas protegidas usan JWT para autenticar al usuario.

## Framework, stack y dependencias principales

Backend:

- PHP 8.2 o superior.
- Laravel Framework 12.
- `tymon/jwt-auth` para autenticacion JWT.
- `spatie/laravel-permission` para roles y permisos.
- `stancl/tenancy` para base multitenant.
- PHPUnit para pruebas.

Frontend:

- Vue 3.
- Vite 7.
- Vue Router.
- Pinia.
- Axios.
- Tailwind CSS.

Herramientas de ejecucion:

- Composer para dependencias PHP.
- Node.js y npm para dependencias frontend.
- Base de datos SQLite o MySQL, segun configuracion del entorno.

## Modulo asignado

Modulo: citas medicas.

El modulo debe permitir administrar citas medicas dentro del sistema, respetando la arquitectura existente del proyecto.

## Entidades principales propuestas

Cita medica:

- Representa una reserva o registro de atencion medica.
- Debe incluir fecha, paciente, responsable y estado.

Paciente:

- Representa a la persona que recibira la atencion medica.
- En el Sprint 2 puede manejarse como campo basico o relacion, segun el alcance aprobado.

Responsable:

- Representa al usuario o persona encargada de atender o gestionar la cita.
- Puede estar asociado al usuario autenticado o registrarse como dato del formulario, segun la implementacion definida.

Estado:

- Representa el ciclo de vida de la cita.
- Estados sugeridos: pendiente, confirmada, cancelada y atendida.

## Archivos y areas que probablemente se tocaran en Sprint 2

- `routes/api.php` para registrar endpoints del CRUD.
- `app/Http/Controllers/Api/V1/` para crear el controlador del modulo.
- `app/Models/` para agregar el modelo de cita medica.
- `database/migrations/` para crear la tabla de citas medicas.
- `tests/` para pruebas del CRUD, si el alcance lo permite.
- `resources/js/` si se agrega pantalla o vista frontend.

## Cambios realizados en el proyecto

- Se creo `docs/evidencias/sprint-1.md` con el analisis del Sprint 1.
- Se creo `docs/evidencias/guia-trazabilidad.md` como guia general para registrar evidencia por sprint.
- Se actualizo el README para enlazar la guia de trazabilidad y resumir la evidencia esperada.

## Verificacion aplicada

Se revisaron los siguientes archivos:

- `README.md` para confirmar arquitectura, stack y flujo general.
- `composer.json` para confirmar dependencias backend.
- `package.json` para confirmar dependencias frontend.
- `routes/web.php` para confirmar la entrada SPA.
- `routes/api.php` para confirmar la estructura actual del API.

Resultado:

- La evidencia del Sprint 1 queda documentada antes de implementar el CRUD.
- El modulo de citas medicas queda definido para ser implementado en Sprint 2.
- No se modifico codigo funcional del sistema en este sprint.

## Commit asociado

```text
docs: documentar analisis inicial del modulo de citas
```
