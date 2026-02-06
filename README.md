# CRM PRO (PHP + MySQL + JS + Bootstrap + SweetAlert2)

Mini CRM moderno con enfoque en velocidad para gestionar contactos y oportunidades.

## Stack
- PHP 8+
- MySQL 8+
- JavaScript
- Bootstrap 5
- SweetAlert2

## Configuración rápida
1. Crea la base de datos y tablas:
   ```bash
   mysql -u root -p < sql/schema.sql
   ```
2. Variables de conexión (opcionales):
   - `DB_HOST` (default `127.0.0.1`)
   - `DB_PORT` (default `3306`)
   - `DB_NAME` (default `crm`)
   - `DB_USER` (default `root`)
   - `DB_PASS` (default vacío)

3. Levanta el servidor local:
   ```bash
   php -S 0.0.0.0:8000
   ```
4. Abre:
   - `http://localhost:8000/index.php`

## Módulos
- **Dashboard** con KPIs y últimas oportunidades.
- **Contactos**: alta y baja con confirmación SweetAlert2.
- **Oportunidades**: alta y visualización de pipeline.

## Mejoras sugeridas para superar Monday
- Roles y permisos (RBAC)
- Automatizaciones tipo workflow (if/then)
- Integración con WhatsApp, correo y telefonía
- Embudo con drag-and-drop estilo Kanban
- API REST + Webhooks + app móvil
