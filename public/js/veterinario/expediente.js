/* ==========================================================================
   expediente.js — Lógica del buscador de expedientes
   ========================================================================== */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {

        const input        = document.getElementById('buscadorExpediente');
        const dropdown     = document.getElementById('resultadosDropdown');
        const spinner      = document.getElementById('buscadorSpinner');
        const seleccionada = document.getElementById('mascotaSeleccionada');
        const acciones     = document.getElementById('expedienteAcciones');
        const btnConsultas = document.getElementById('btnVerConsultas');
        const btnNueva     = document.getElementById('btnNuevaMascota');

        if (!input) return;

        let debounceTimer = null;
        let mascotaActual = null;

        // ── Búsqueda con debounce ─────────────────────────────────
        input.addEventListener('input', function () {
            const q = this.value.trim();

            // Limpiar selección si el usuario escribe de nuevo
            ocultarSeleccion();

            if (q.length < 2) {
                dropdown.classList.remove('visible');
                dropdown.innerHTML = '';
                return;
            }

            clearTimeout(debounceTimer);
            spinner.style.display = 'block';

            debounceTimer = setTimeout(function () {
                buscarMascotas(q);
            }, 300);
        });

        // ── Cerrar dropdown al hacer clic fuera ───────────────────
        document.addEventListener('click', function (e) {
            if (!input.closest('.buscador-input-wrapper')?.contains(e.target)) {
                dropdown.classList.remove('visible');
            }
        });

        // ── Llamada AJAX al backend ───────────────────────────────
        function buscarMascotas(q) {
            const url = input.dataset.searchUrl + '?q=' + encodeURIComponent(q);

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                spinner.style.display = 'none';
                renderResultados(data);
            })
            .catch(() => {
                spinner.style.display = 'none';
                dropdown.innerHTML = '<div class="sin-resultados"><i class="fas fa-exclamation-circle mr-1 text-danger"></i> Error al buscar. Intenta de nuevo.</div>';
                dropdown.classList.add('visible');
            });
        }

        // ── Renderizar resultados en el dropdown ──────────────────
        function renderResultados(mascotas) {
            dropdown.innerHTML = '';

            if (!mascotas.length) {
                dropdown.innerHTML = '<div class="sin-resultados"><i class="fas fa-search mr-1"></i> Sin resultados. <a href="' + (btnNueva?.dataset.nuevaUrl || '#') + '">Registrar nueva mascota</a></div>';
                dropdown.classList.add('visible');
                return;
            }

            mascotas.forEach(function (m) {
                const item = document.createElement('div');
                item.className = 'resultado-item';
                item.innerHTML = `
                    <div>
                        <div class="resultado-mascota-nombre">
                            ${m.emoji} ${m.nombre}
                        </div>
                        <div class="resultado-dueno">
                            <i class="fas fa-user" style="font-size:0.7rem"></i>
                            Dueño: ${m.dueno ?? 'Sin registrar'}
                        </div>
                    </div>
                    <span class="resultado-folio">Folio: ${m.folio}</span>
                `;

                item.addEventListener('click', function () {
                    seleccionarMascota(m);
                });

                dropdown.appendChild(item);
            });

            dropdown.classList.add('visible');
        }

        // ── Seleccionar una mascota ───────────────────────────────
        function seleccionarMascota(m) {
            mascotaActual = m;

            // Actualizar input
            input.value = m.nombre;
            dropdown.classList.remove('visible');

            // Mostrar chip de seleccionada
            document.getElementById('selNombre').textContent  = m.nombre;
            document.getElementById('selDetalle').textContent =
                'Folio #' + m.folio + (m.dueno ? ' — ' + m.dueno : ' — Sin dueño');
            document.getElementById('selEmoji').textContent   = m.emoji;

            seleccionada.classList.add('visible');
            acciones.classList.add('visible');

            // Actualizar hrefs de botones
            if (btnConsultas) btnConsultas.href = m.urlConsultas;
            if (btnNueva) btnNueva.href = m.urlNuevaMascota;
        }

        // ── Ocultar selección ─────────────────────────────────────
        function ocultarSeleccion() {
            mascotaActual = null;
            seleccionada.classList.remove('visible');
            acciones.classList.remove('visible');
        }

        // ── Botón limpiar selección ───────────────────────────────
        document.getElementById('btnLimpiarSeleccion')?.addEventListener('click', function () {
            input.value = '';
            dropdown.innerHTML = '';
            dropdown.classList.remove('visible');
            ocultarSeleccion();
            input.focus();
        });

    });
})();
