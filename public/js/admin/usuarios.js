/* ==========================================================================
   usuarios.js — Lógica del módulo de Gestión de Usuarios
   ========================================================================== */

(function () {
    'use strict';

    // ── Esperar a que el DOM esté listo ──────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function () {

        // ────────────────────────────────────────────────────────────────────
        // 1. Toggle sección veterinario según el rol seleccionado
        // ────────────────────────────────────────────────────────────────────
        const selectRol          = document.getElementById('rol');
        const seccionVeterinario = document.getElementById('seccion-veterinario');

        function toggleSeccionVeterinario() {
            if (!selectRol || !seccionVeterinario) return;

            if (selectRol.value === 'veterinario') {
                seccionVeterinario.style.display = 'block';
                // Hacer campos obligatorios
                document.getElementById('nombre_completo')?.removeAttribute('disabled');
            } else {
                seccionVeterinario.style.display = 'none';
                // Limpiar campos veterinario al cambiar a admin
                const inputsVet = seccionVeterinario.querySelectorAll('input, textarea, select');
                inputsVet.forEach(function (input) {
                    if (input.type !== 'file') input.value = '';
                });
            }
        }

        if (selectRol) {
            // Estado inicial
            toggleSeccionVeterinario();
            // Escuchar cambios
            selectRol.addEventListener('change', toggleSeccionVeterinario);
        }

        // ────────────────────────────────────────────────────────────────────
        // 2. Toggle mostrar/ocultar contraseña
        // ────────────────────────────────────────────────────────────────────
        function initTogglePassword(toggleId, inputId, iconId) {
            const btn   = document.getElementById(toggleId);
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);

            if (!btn || !input || !icon) return;

            btn.addEventListener('click', function () {
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                icon.classList.toggle('fa-eye',       !isHidden);
                icon.classList.toggle('fa-eye-slash',  isHidden);
                btn.style.color = isHidden ? '#4e73df' : '#b7b9cc';
            });
        }

        initTogglePassword('togglePassword',        'password',              'eyeIconPassword');
        initTogglePassword('togglePasswordConfirm', 'password_confirmation', 'eyeIconConfirm');

        // ────────────────────────────────────────────────────────────────────
        // 3. Toggle "Cambiar contraseña" en el formulario de edición
        // ────────────────────────────────────────────────────────────────────
        const btnCambiarPassword = document.getElementById('btnCambiarPassword');
        const seccionPassword    = document.getElementById('seccion-password');

        if (btnCambiarPassword && seccionPassword) {
            btnCambiarPassword.addEventListener('click', function () {
                const visible = seccionPassword.style.display !== 'none';
                seccionPassword.style.display = visible ? 'none' : 'block';
                this.innerHTML = visible
                    ? '<i class="fas fa-lock mr-1"></i> Cambiar contraseña'
                    : '<i class="fas fa-lock-open mr-1"></i> Cancelar cambio';

                // Limpiar campos si se cancela
                if (visible) {
                    seccionPassword.querySelectorAll('input').forEach(i => i.value = '');
                }
            });
        }

        // ────────────────────────────────────────────────────────────────────
        // 4. Preview de la imagen de firma antes de subir
        // ────────────────────────────────────────────────────────────────────
        const inputFirma   = document.getElementById('foto_firma');
        const previewFirma = document.getElementById('preview-firma');

        if (inputFirma && previewFirma) {
            inputFirma.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;

                if (!file.type.startsWith('image/')) {
                    alert('Por favor selecciona un archivo de imagen válido.');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    previewFirma.src = e.target.result;
                    previewFirma.style.display = 'block';
                };
                reader.readAsDataURL(file);
            });
        }

        // ────────────────────────────────────────────────────────────────────
        // 5. Confirmar eliminación de usuario
        // ────────────────────────────────────────────────────────────────────
        const botonesEliminar = document.querySelectorAll('[data-delete-form]');

        botonesEliminar.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const nombre    = this.dataset.userName || 'este usuario';
                const formId    = this.dataset.deleteForm;
                const form      = document.getElementById(formId);

                if (!form) return;

                // Rellenar el modal de confirmación
                const modalNombre = document.getElementById('deleteUserName');
                if (modalNombre) modalNombre.textContent = nombre;

                // Al confirmar en el modal
                const btnConfirmar = document.getElementById('btnConfirmarEliminar');
                if (btnConfirmar) {
                    // Remover listeners anteriores clonando el botón
                    const nuevoBtn = btnConfirmar.cloneNode(true);
                    btnConfirmar.parentNode.replaceChild(nuevoBtn, btnConfirmar);
                    nuevoBtn.addEventListener('click', function () {
                        form.submit();
                    });
                }

                // Abrir modal
                $('#modalEliminar').modal('show');
            });
        });

        // ────────────────────────────────────────────────────────────────────
        // 6. Auto-ocultar alertas de sesión después de 5 segundos
        // ────────────────────────────────────────────────────────────────────
        const alertas = document.querySelectorAll('.alert-session');
        alertas.forEach(function (alerta) {
            setTimeout(function () {
                alerta.style.transition = 'opacity 0.5s ease';
                alerta.style.opacity    = '0';
                setTimeout(function () { alerta.remove(); }, 500);
            }, 5000);
        });

        // ────────────────────────────────────────────────────────────────────
        // 7. Búsqueda en tiempo real en la tabla (client-side básico)
        // ────────────────────────────────────────────────────────────────────
        const inputBuscar = document.getElementById('buscarUsuario');
        const tablaBody   = document.querySelector('#tablaUsuarios tbody');

        if (inputBuscar && tablaBody) {
            inputBuscar.addEventListener('input', function () {
                const termino = this.value.toLowerCase().trim();
                const filas   = tablaBody.querySelectorAll('tr');

                filas.forEach(function (fila) {
                    const texto = fila.textContent.toLowerCase();
                    fila.style.display = texto.includes(termino) ? '' : 'none';
                });
            });
        }

    }); // DOMContentLoaded

})();
