# Guia de trazabilidad del proyecto

Esta guia define como registrar la evidencia del proyecto para evitar una entrega generada en una sola ejecucion sin trazabilidad. Cada sprint debe mostrar avance, decisiones, cambios y verificacion real dentro del repositorio.

## Estructura recomendada

```text
docs/
  evidencias/
    guia-trazabilidad.md
    sprint-1.md
    sprint-2.md
    sprint-3.md
```

## Evidencia minima por sprint

Cada sprint debe registrar:

- Prompt usado.
- Objetivo del prompt.
- Resumen de la respuesta recibida.
- Decision humana tomada.
- Cambios realizados en el proyecto.
- Verificacion aplicada.
- Commit asociado.

## Sprint 1

Analisis de arquitectura, framework, stack y base estructural del modulo asignado.

## Sprint 2

Implementacion del CRUD basico de citas medicas con fecha, paciente, responsable y estado.

## Sprint 3

Diagramas UML base global para el modulo solicitado.

## Commits

Los commits deben usar mensajes claros que permitan entender el avance realizado.

Ejemplos:

```text
docs: documentar analisis inicial del modulo de citas
feat: implementar CRUD basico de citas medicas
docs: agregar diagramas UML del modulo de citas
```
