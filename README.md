# ZendTicket

![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?logo=tailwindcss&logoColor=white)
![Pest](https://img.shields.io/badge/Tests-Pest-5A0FC8)
![RBAC](https://img.shields.io/badge/RBAC-Spatie_Permission-informational)

Sistema de gestión de tickets construido con **Laravel 13**, Blade y Tailwind CSS.

ZendTicket permite registrar solicitudes, clasificarlas por departamento, categoría y prioridad, asignarlas a agentes y controlar su ciclo de vida mediante un workflow de estados con autorización por roles y permisos, trazabilidad de actividades y pruebas automatizadas.

> Proyecto de portafolio enfocado en desarrollo full-stack con Laravel, reglas de negocio, autorización, persistencia transaccional y separación de responsabilidades.

---

## Contenido

- [Sobre el proyecto](#sobre-el-proyecto)
- [Funcionalidades](#funcionalidades)
- [Stack](#stack)
- [Arquitectura](#arquitectura)
- [Workflow de tickets](#workflow-de-tickets)
- [Roles y permisos](#roles-y-permisos)
- [Auditoría](#auditoría)
- [Testing](#testing)
- [Datos iniciales](#datos-iniciales)
- [Cómo ejecutar el proyecto](#cómo-ejecutar-el-proyecto)
- [Autor](#autor)

---

## Sobre el proyecto

ZendTicket modela actualmente el flujo principal de gestión de solicitudes:

- Creación de tickets por usuarios autorizados.
- Clasificación por departamento, categoría y prioridad.
- Numeración anual de tickets con formato `ZT-AAAA-000001`.
- Listado de tickets según el alcance del usuario.
- Visualización del detalle de una solicitud.
- Asignación y reasignación a agentes activos.
- Cambio de prioridad por usuarios autorizados.
- Resolución, reapertura y cierre mediante transiciones controladas.
- Registro de las actividades principales del workflow.

El proyecto utiliza permisos para limitar las operaciones disponibles y reglas de dominio para impedir transiciones de estado inválidas.

---

## Funcionalidades

### Autenticación

- Inicio de sesión con email y contraseña.
- Opción `remember me`.
- Regeneración de sesión después de autenticar.
- Limitación de intentos de login por combinación de email e IP.
- Cierre de sesión con invalidación de sesión y regeneración del token.
- Recuperación y restablecimiento de contraseña.
- Rutas privadas protegidas con middleware `auth`.

### Tickets

- Creación de tickets.
- Número de ticket generado con secuencia anual.
- Departamento, categoría y prioridad obligatorios.
- Validación de que la categoría seleccionada pertenece al departamento indicado.
- Estado inicial `open`.
- Listado paginado de tickets.
- Visibilidad según permisos: tickets propios, asignados o todos.
- Vista de detalle con solicitante, departamento, categoría, prioridad, estado y agente asignado.

### Asignación

- Asignación de tickets abiertos a agentes activos.
- Reasignación de tickets en progreso.
- Validación de que el usuario seleccionado tenga rol de agente y esté activo.
- Prevención de reasignación al mismo agente.
- La primera asignación registra `assigned_at`.
- Las reasignaciones conservan la fecha de primera asignación.
- La asignación de un ticket abierto cambia automáticamente su estado a `in_progress`.
- No se permite asignar o reasignar tickets resueltos o cerrados.

### Prioridad

- Cambio de prioridad por usuarios autorizados.
- Solo se puede modificar en tickets `open` o `in_progress`.
- Solo se muestran prioridades activas para la modificación.

### Workflow de estados

Las transiciones implementadas son:

```text
OPEN
  └── assign ─────────────→ IN_PROGRESS
                               │
                               └── resolve ──→ RESOLVED
                                                 │
                                      ┌── reopen ┘
                                      │
                                      └── close ──→ CLOSED
```

Reglas actuales:

- `open → in_progress` al realizar la primera asignación.
- La reasignación mantiene el ticket en `in_progress`.
- `in_progress → resolved` al resolver.
- `resolved → in_progress` al reabrir.
- `resolved → closed` al cerrar.
- `closed` es un estado final.
- Las transiciones no definidas son rechazadas por la lógica de dominio.

### Fechas del ciclo de vida

- `assigned_at`: primera asignación del ticket.
- `resolved_at`: momento de resolución; se limpia al reabrir.
- `closed_at`: momento de cierre.
- Al cerrar un ticket se conserva `resolved_at`.

---

## Stack

### Backend

- **PHP 8.3+**
- **Laravel 13**
- **Eloquent ORM**
- **Blade**
- **Spatie Laravel Permission**

### Frontend

- **Blade**
- **Tailwind CSS 4**
- **JavaScript**
- **Blade Heroicons**
- **Vite**

### Base de datos

- **MySQL**

### Testing y herramientas

- **Pest**
- **Laravel Pint**
- **Composer**
- **NPM**

---

## Arquitectura

```text
app/
  Actions/
    Tickets/
      TransitionTicketStatusAction.php
      RecordTicketActivityAction.php
  Http/
    Controllers/
      Auth/
      TicketController.php
    Requests/
      Auth/
      AssignTicketRequest.php
      StoreTicketRequest.php
      UpdateTicketPriorityRequest.php
  Models/
  Policies/
    TicketPolicy.php

database/
  migrations/
  seeders/
    data/                  → catálogos y usuarios cargados desde CSV

resources/
  views/
    auth/
    tickets/

routes/
  web.php

tests/
  Feature/
```

La aplicación mantiene separadas varias responsabilidades:

- **Form Requests** para validación y autorización de solicitudes con datos.
- **Policies** para autorización sobre tickets.
- **Actions** para reglas específicas del workflow y registro de actividades.
- **Controllers** para orquestar los casos de uso.
- **Eloquent Models** para relaciones, scopes y persistencia.
- **Blade** para la presentación.

### Persistencia y consistencia

La creación de tickets utiliza una transacción de base de datos y bloqueo con `lockForUpdate()` sobre la secuencia anual antes de generar el siguiente número.

Los cambios de asignación y estado que generan actividades se ejecutan dentro de transacciones para mantener consistente el ticket con su registro de auditoría.

---

## Workflow de tickets

`TransitionTicketStatusAction` centraliza las transiciones permitidas y los timestamps asociados al ciclo de vida.

Las acciones de resolución, reapertura y cierre están expuestas mediante endpoints independientes y son autorizadas antes de ejecutar la transición.

La interfaz solo muestra acciones compatibles con el estado actual, mientras que la lógica de dominio vuelve a validar la transición en el backend.

---

## Roles y permisos

ZendTicket utiliza **Spatie Laravel Permission**.

Los roles cargados actualmente son:

| Rol | Alcance implementado |
| --- | --- |
| Customer | Crear tickets, consultar tickets propios, crear comentarios y adjuntos según permisos configurados |
| Agent | Consultar tickets asignados, actualizar tickets y resolver sus tickets asignados |
| Supervisor | Consultar tickets, asignar/reasignar, resolver, reabrir, cambiar prioridad y cerrar |
| Admin | Gestión amplia de tickets y permisos administrativos configurados |

Para el workflow actual:

- Un agente solo puede resolver un ticket asignado a él.
- Los agentes no pueden reabrir ni cerrar tickets.
- Supervisor y Admin tienen permisos para resolver, reabrir y cerrar.
- La asignación y reasignación están restringidas a usuarios con `tickets.assign`.

---

## Auditoría

Las actividades del workflow se almacenan en `ticket_activities`.

Actualmente se registran:

- `assigned`
- `reassigned`
- `resolved`
- `reopened`
- `closed`

Cada actividad almacena el usuario que ejecutó la acción y los valores relevantes anteriores y nuevos.

Ejemplo conceptual de una resolución:

```json
{
  "action": "resolved",
  "old_values": {
    "status": "in_progress"
  },
  "new_values": {
    "status": "resolved"
  }
}
```

La asignación y reasignación registran además el agente anterior y nuevo junto con el estado correspondiente.

---

## Testing

El proyecto utiliza **Pest** para pruebas automatizadas.

La suite actual incluye pruebas de relaciones entre modelos y del workflow de estados.

`TicketStatusWorkflowTest` verifica, entre otros casos:

- Primera asignación y registro de `assigned_at`.
- Reasignación conservando `assigned_at`.
- Rechazo de asignación en tickets resueltos o cerrados.
- Resolución por el agente asignado.
- Rechazo cuando otro agente intenta resolver.
- Registro de `resolved_at`.
- Reapertura de tickets resueltos.
- Limpieza de `resolved_at` al reabrir.
- Rechazo de reapertura de tickets cerrados.
- Cierre de tickets resueltos.
- Registro de `closed_at`.
- Rechazo del cierre por un agente.
- Rechazo de transiciones desde estados no permitidos.
- Registro de actividades del workflow.

La suite completa validada actualmente ejecuta:

```text
17 tests passed
66 assertions
```

Para ejecutar las pruebas:

```bash
php artisan test
```

Los tests utilizan SQLite en memoria mediante la configuración de PHPUnit.

---

## Datos iniciales

Los datos iniciales del proyecto se cargan mediante seeders.

Los catálogos almacenados en archivos CSV incluyen:

- Departamentos.
- Categorías.
- Prioridades.
- Estados de ticket.
- Usuarios de datos iniciales.

También existe un seeder dedicado para roles y permisos.

Los estados actuales son:

```text
open
in_progress
resolved
closed
```

---

## Cómo ejecutar el proyecto

### Requisitos

- PHP 8.3 o superior.
- Composer.
- Node.js y NPM.
- MySQL.
- Git.

### Instalación

1. Clona el repositorio:

```bash
git clone https://github.com/josecarlosonate/ZendTicket.git
cd ZendTicket
```

2. Instala las dependencias:

```bash
composer install
npm install
```

3. Crea el archivo de entorno:

```bash
cp .env.example .env
```

4. Genera la clave de la aplicación:

```bash
php artisan key:generate
```

5. Configura la conexión MySQL en `.env`.

6. Ejecuta migraciones y seeders:

```bash
php artisan migrate --seed
```

7. Inicia el entorno de desarrollo:

```bash
composer run dev
```

La aplicación estará disponible utilizando la URL mostrada por el servidor de desarrollo de Laravel.

---

## Autor

**Jose Carlos Oñate Rodríguez**

Proyecto de portafolio — Laravel / Blade / Tailwind CSS / MySQL
