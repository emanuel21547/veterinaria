# 🐾 Sistema de Gestión Veterinaria

¡Bienvenido al **Sistema de Gestión Veterinaria**! Este es un sistema integral desarrollado en Laravel para la administración de clínicas veterinarias, control de pacientes, expedientes clínicos y gestión de personal.

## 👥 Roles y Funcionalidades

El sistema cuenta con un control de acceso basado en roles. Dependiendo del usuario que inicie sesión, el sistema adaptará su interfaz y funcionalidades:

### 1. 🛡️ Rol Administrador (Gerencia)
El Administrador tiene el control total sobre la clínica y el personal. Su interfaz está orientada a la gestión operativa.
*   **Gestión de Usuarios:** Módulo CRUD completo para registrar a los empleados de la clínica. Puede asignar el rol de *Administrador* o *Veterinario*.
*   **Control de Veterinarios:** Si el usuario creado es un Veterinario, el administrador registra sus credenciales profesionales (Cédula profesional, especialidad, teléfono).
*   **Gestión de Dueños (Clientes):** Registro y control del directorio de dueños de las mascotas.
*   **Gestión de Mascotas (Pacientes):** Registro general de mascotas, vinculación con su dueño, asignación de especie, raza, edad, etc.
*   **Configuración del Sistema:** Acceso a configurar los datos públicos de la clínica (Nombre, Teléfono, Misión, Visión, Valores, etc.).

### 2. 🩺 Rol Veterinario (Médico)
El Veterinario tiene una interfaz completamente libre de distracciones administrativas, enfocada 100% en el paciente (Dashboard Clínico Inteligente).
*   **Buscador de Expedientes:** Pantalla principal enfocada en buscar rápidamente pacientes por su nombre o por el nombre del dueño.
*   **Dashboard Clínico de la Mascota:** Al seleccionar un paciente, el sistema se transforma y enfoca la barra lateral en esa mascota específica.
*   **Historial de Consultas:** Registro de signos vitales (peso, talla) e integración de un editor de texto profesional (**CKEditor 5**) para redactar el Diagnóstico y el Tratamiento de forma rica (negritas, listas, formato libre).
*   **Gestión de Antecedentes (CRUD independiente):**
    *   **Alergias:** Registro de sustancias alérgenas y reacciones.
    *   **Lesiones:** Registro del tipo de lesiones padecidas.
    *   **Patologías:** Registro de enfermedades pasadas, marcando si son crónicas o no.
    *   **Alimentación:** Control de la dieta del animal y frecuencias.

---

## 🔄 Flujo de Trabajo Ideal

1.  **Recepción / Admin:** Llega un cliente nuevo a la clínica. El administrador entra al sistema, registra al **Dueño** y posteriormente registra a la **Mascota** asignándola a ese dueño.
2.  **Consultorio / Veterinario:** El veterinario entra con su cuenta. En la barra de búsqueda teclea el nombre de la mascota recién registrada.
3.  **Expediente:** El veterinario entra al expediente. El sistema le indica en la barra superior verde el "Paciente seleccionado".
4.  **Atención Médica:** El veterinario revisa los antecedentes (si es alérgico a algo, etc.). Procede a registrar una **Nueva Consulta**, anotando el peso, talla, y redactando el diagnóstico/tratamiento.
5.  **Fin de sesión:** Al terminar, el veterinario regresa al listado de expedientes y la interfaz se "limpia" esperando al siguiente paciente.

---

## 📂 Estructura Principal del Proyecto

El sistema está organizado bajo la arquitectura MVC (Modelo-Vista-Controlador) de Laravel. Aquí la distribución clave de los archivos que hacen funcionar la magia:

```text
veterinaria/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Controladores (Lógica)
│   │   │   ├── AdminController.php
│   │   │   ├── AuthController.php          # Lógica de Login
│   │   │   ├── DuenoController.php
│   │   │   ├── MascotaController.php
│   │   │   ├── UsuarioController.php       # Alta de empleados
│   │   │   └── VeterinarioController.php   # Toda la lógica del Expediente Clínico
│   │   ├── Middleware/
│   │   │   └── CheckRoleAdmin.php          # Protección de rutas Admin
│   ├── Models/                   # Modelos (Base de Datos)
│   │   ├── AntecedenteAlergia.php
│   │   ├── AntecedenteLesion.php
│   │   ├── AntecedentePatologico.php
│   │   ├── ConfiguracionSistema.php
│   │   ├── Consulta.php
│   │   ├── Dueno.php
│   │   ├── HistorialAlimentacion.php
│   │   ├── Mascota.php
│   │   ├── User.php
│   │   └── Veterinario.php
│
├── database/
│   ├── migrations/               # Estructura de todas las tablas de MySQL
│   └── seeders/                  # Datos de prueba (Admin por defecto)
│
├── public/
│   ├── css/                      # Estilos personalizados (Admin, Login, Expediente)
│   ├── startbootstrap/           # Plantilla base SB Admin 2
│   └── ...
│
├── resources/
│   ├── views/                    # Interfaz de Usuario (HTML/Blade)
│   │   ├── auth/
│   │   │   └── login.blade.php             # Pantalla de Login
│   │   ├── layouts/
│   │   │   ├── main.blade.php              # Plantilla Maestra Compartida
│   │   │   └── partials/                   # Menús laterales y barra superior dinámica
│   │   ├── modules/
│   │   │   ├── admin/                      # Vistas del Gerente (Usuarios, Config)
│   │   │   ├── duenos/                     # Vistas CRUD Dueños
│   │   │   ├── mascotas/                   # Vistas CRUD Mascotas
│   │   │   └── veterinario/                # Vistas del Médico
│   │   │       ├── antecedentes/           # (Alergias, lesiones, patologías)
│   │   │       ├── expediente/             # Buscador y Consultas
│   │   │       └── historial/              # Alimentación
│
└── routes/
    └── web.php                   # Rutas separadas e identificadas por rol
```

---

## 🚀 Instalación (Para desarrolladores)

Si descargaste este repositorio y quieres correrlo en tu máquina:

1.  Clona el repositorio.
2.  Abre la terminal en la carpeta del proyecto y ejecuta `composer install`.
3.  Crea tu archivo `.env` copiando el `.env.example`.
4.  Genera la llave de la app con `php artisan key:generate`.
5.  Configura tu base de datos en el archivo `.env` (MySQL).
6.  Ejecuta las migraciones y seeders: `php artisan migrate --seed` (Esto creará la base de datos y al usuario administrador por defecto).
7.  Ejecuta el servidor: `php artisan serve`.
