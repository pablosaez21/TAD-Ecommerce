---

# Double Helix: Deporte en nuestro ADN

¡Bienvenido a **Double Helix**! Un e-commerce deportivo de alto rendimiento desarrollado como proyecto académico. Nuestra plataforma fusiona la potencia de Laravel con una interfaz ágil basada en Bootstrap 5.

---

## Stack Tecnológico

| Componente | Tecnología |
| :--- | :--- |
| **Backend** | ![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white) **9** (PHP 8.1+) |
| **Frontend** | ![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=flat-square&logo=bootstrap&logoColor=white) **5** + Blade Templates |
| **Base de Datos** | ![SQLite](https://img.shields.io/badge/SQLite-07405E?style=flat-square&logo=sqlite&logoColor=white) |
| **Autenticación** | Laravel Fortify |
| **Testing Email** | Mailtrap |

---

## Características Principales

*   **Gestión de Catálogo:** Navegación fluida por productos deportivos.
*   **Autenticación Segura:** Implementada con Laravel Fortify para un control de acceso robusto.
*   **Diseño Responsive:** Adaptado a cualquier dispositivo gracias a Bootstrap 5.
*   **Simulación de Correo:** Integración con Mailtrap para el envío de notificaciones y confirmaciones.
*   **Multi-idioma:** Soporte completo para **Español** e **Inglés**, permitiendo que usuarios de distintos países naveguen cómodamente por la tienda.
*   **Datos de Prueba (Seeders):** Incluye generadores de datos automáticos para poblar la tienda con diversos tipos de productos y categorías, facilitando las pruebas de desarrollo.   
---

## Integrantes del Grupo

Nuestro equipo de desarrollo está compuesto por:

*   **Pablo Sáez Morales**
*   **Oleksandr B. Baranets**
*   **Nicolás Porra Collado**

---

## Instalación y Configuración

Sigue estos pasos para levantar el proyecto en tu entorno local:

1.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/tu-usuario/double-helix.git
    cd double-helix
    ```

2.  **Instalar dependencias:**
    ```bash
    composer install
    npm install && npm run dev
    ```

3.  **Configuración del entorno:**
    *   Copia el archivo `.env.example` a `.env`.
    *   Configura tu base de Datos SQLite.
    *   Añade tus credenciales de **Mailtrap** en el `.env`.

4.  **Migraciones y Key:**
    ```bash
    php artisan key:generate
    php artisan migrate --seed
    ```
