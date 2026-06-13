# Guia de trazabilidad del proyecto

Esta guia define como se registrara la evidencia del proyecto para evitar una entrega generada en una sola ejecucion sin trazabilidad. Cada sprint debe mostrar avance, decisiones, cambios y verificacion real dentro del repositorio.

## Objetivo

Dejar evidencia clara y verificable de:

- Lo que se analizo o implemento.
- El prompt usado y su objetivo.
- La respuesta recibida de la herramienta.
- La decision humana tomada antes de avanzar.
- Los cambios realizados en el proyecto.
- La verificacion aplicada.
- Los commits asociados.

## Estructura recomendada

```text
docs/
  evidencias/
    guia-trazabilidad.md
    sprint-1.md
    sprint-2.md
    sprint-3.md
```

## Sprint 1: analisis y base estructural

El Sprint 1 debe documentar el primer avance funcional o estructural del modulo asignado. En este proyecto se usara como sprint de analisis tecnico y definicion base.

Contenido esperado:

- Analisis de la arquitectura existente.
- Framework usado: Laravel 12 y Vue 3 con Vite.
- Stack principal: PHP, Composer, Node.js, npm, JWT, Spatie Permission, Stancl Tenancy y Axios.
- Modulo asignado: citas medicas.
- Alcance inicial del modulo.
- Entidades principales propuestas: cita medica, paciente, responsable y estado.
- Rutas, controladores, modelos, migraciones o vistas que se planean tocar.
- Riesgos o dependencias detectadas.

Evidencia minima:

```text
Prompt usado:
Objetivo del prompt:
Resumen de la respuesta recibida:
Decision humana tomada:
Cambios realizados en el proyecto:
Verificacion aplicada:
Commit asociado:
```

Ejemplo de commit:

```text
docs: documentar analisis inicial del modulo de citas
```

## Sprint 2: CRUD basico de citas medicas

El Sprint 2 debe implementar el CRUD basico del modulo solicitado.

Alcance funcional:

- Crear citas medicas.
- Listar citas medicas.
- Ver el detalle de una cita medica.
- Actualizar una cita medica.
- Eliminar una cita medica.

Campos minimos de la cita medica:

- Fecha.
- Paciente.
- Responsable.
- Estado.

Estados sugeridos:

- Pendiente.
- Confirmada.
- Cancelada.
- Atendida.

Evidencia minima:

```text
Prompt usado:
Objetivo del prompt:
Resumen de la respuesta recibida:
Decision humana tomada:
Cambios realizados en el proyecto:
Verificacion aplicada:
Commit asociado:
```

Verificacion sugerida:

- Ejecutar migraciones.
- Probar endpoints del API.
- Revisar validaciones de campos obligatorios.
- Ejecutar pruebas automatizadas si existen.
- Confirmar que el frontend o la respuesta JSON permite revisar el CRUD.

Ejemplos de commits:

```text
feat: agregar modelo y migracion de citas medicas
feat: implementar endpoints CRUD de citas medicas
test: cubrir operaciones basicas de citas medicas
```

## Sprint 3: diagramas UML base global

El Sprint 3 debe documentar diagramas UML base global para el modulo solicitado.

Diagramas sugeridos:

- Diagrama de casos de uso del modulo de citas medicas.
- Diagrama de clases con entidades principales.
- Diagrama de secuencia para crear o actualizar una cita.
- Diagrama de componentes si se quiere mostrar la relacion API, frontend y base de datos.

Evidencia minima:

```text
Prompt usado:
Objetivo del prompt:
Resumen de la respuesta recibida:
Decision humana tomada:
Cambios realizados en el proyecto:
Verificacion aplicada:
Commit asociado:
```

Verificacion sugerida:

- Confirmar que los diagramas coinciden con el CRUD implementado.
- Revisar nombres de clases, rutas y campos contra el codigo real.
- Exportar los diagramas o dejarlos en formato editable, por ejemplo PlantUML, Mermaid o imagen.

Ejemplos de commits:

```text
docs: agregar diagramas UML del modulo de citas
docs: actualizar guia de revision del modulo de citas
```

## Reglas para commits

Los commits deben explicar que se trabajo. Se recomienda usar mensajes cortos con prefijo:

- `docs:` para documentacion o evidencia.
- `feat:` para nueva funcionalidad.
- `fix:` para correcciones.
- `test:` para pruebas.
- `refactor:` para ajustes internos sin cambiar comportamiento.

Ejemplos validos:

```text
docs: registrar evidencia del sprint 1
feat: implementar CRUD basico de citas medicas
docs: agregar diagramas UML base del modulo de citas
```

## README o notas breves

El README debe indicar:

- Que se implemento.
- Como revisar la solucion.
- Requisitos para ejecutar el proyecto.
- Endpoints o pantallas principales del modulo.
- Ubicacion de la evidencia por sprint.

## Criterio de integridad

Una entrega puede ser penalizada si parece generada en una sola ejecucion sin revision real. Para evitarlo, cada sprint debe incluir evidencia de avance progresivo y verificable:

- Analisis antes de implementar.
- Implementacion despues de definir alcance.
- Verificacion con comandos, pruebas o revision manual.
- Decision humana documentada.
- Commits separados por etapa.
