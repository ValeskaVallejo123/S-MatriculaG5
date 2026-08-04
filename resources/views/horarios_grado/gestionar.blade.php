@extends('layouts.app')

@section('title', 'Gestionar Horario')
@section('page-title', 'Gestionar Horario de Clases')

@push('styles')
<style>
:root {
    --cp: #00508f; --cd: #003b73; --cs: #4ec7d2;
    --cg: #10b981; --ca: #f59e0b; --ce: #ef4444;
    --cb: #e2e8f0; --cf: #f8fafc; --ct: #1e293b; --cm: #64748b;
}

/* ── Layout 2 columnas ── */
.hg-wrap {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 1.25rem;
    align-items: start;
}
@media(max-width:1100px) { .hg-wrap { grid-template-columns: 1fr; } }

/* ── Panel izquierdo ── */
.hg-panel {
    background: white; border: 1.5px solid var(--cb);
    border-radius: 14px; overflow: hidden;
    position: sticky; top: 1rem;
}
.hg-panel-head {
    background: linear-gradient(135deg, var(--cd), var(--cp));
    padding: .8rem 1rem; color: white;
    font-weight: 700; font-size: .83rem;
    display: flex; align-items: center; gap: .5rem;
}
.hg-panel-head i { color: var(--cs); }
.hg-panel-body  { padding: .9rem; }

.hg-field { margin-bottom: .8rem; }
.hg-field:last-child { margin-bottom: 0; }
.hg-label {
    display: block; font-size: .68rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em;
    color: var(--cm); margin-bottom: .3rem;
}
.hg-select {
    width: 100%; padding: .45rem .7rem;
    border: 1.5px solid var(--cb); border-radius: 8px;
    font-size: .82rem; color: var(--ct); background: var(--cf);
    outline: none; transition: border-color .15s;
}
.hg-select:focus { border-color: var(--cs); background: white; }

.btn-load {
    width: 100%; padding: .52rem; border-radius: 9px;
    background: linear-gradient(135deg, var(--cs), var(--cp));
    color: white; border: none; font-weight: 700; font-size: .82rem;
    cursor: pointer; margin-top: .4rem;
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    transition: opacity .15s;
}
.btn-load:hover { opacity: .88; }

/* Estudiantes */
.est-list { max-height: 260px; overflow-y: auto; }
.est-item {
    display: flex; align-items: center; gap: .55rem;
    padding: .38rem .45rem; border-radius: 7px; font-size: .76rem;
    color: var(--ct); border-bottom: 1px solid #f1f5f9;
}
.est-item:last-child { border-bottom: none; }
.est-item:hover { background: var(--cf); }
.est-av {
    width: 26px; height: 26px; border-radius: 7px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--cs), var(--cp));
    color: white; font-size: .68rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
}
.est-num { font-size: .63rem; color: var(--cm); margin-left: auto; }

/* ── Panel derecho ── */
.hg-main { display: flex; flex-direction: column; gap: 1rem; min-width: 0; }

/* Info grado */
.grado-info {
    background: linear-gradient(135deg, var(--cd), var(--cp));
    border-radius: 12px; padding: .9rem 1.25rem; color: white;
    display: flex; align-items: center; gap: .75rem; flex-wrap: wrap;
}
.grado-info-title { font-size: 1rem; font-weight: 800; }
.grado-info-sub   { font-size: .72rem; opacity: .7; margin-top: .15rem; }
.gi-chip {
    background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.3);
    border-radius: 999px; padding: .18rem .6rem;
    font-size: .7rem; font-weight: 700; white-space: nowrap;
}

/* ── Card horario ── */
.hg-card {
    background: white; border: 1.5px solid var(--cb);
    border-radius: 14px; overflow: hidden;
}
.hg-card-head {
    padding: .75rem 1.1rem; border-bottom: 1px solid var(--cb);
    display: flex; align-items: center; justify-content: space-between;
    background: var(--cf); flex-wrap: wrap; gap: .5rem;
}
.hg-card-title {
    font-size: .78rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--cp);
    display: flex; align-items: center; gap: .4rem;
}
.hg-card-title i { color: var(--cs); }
.conflict-legend {
    font-size: .72rem; color: var(--cm);
    display: flex; align-items: center; gap: .3rem;
}

/* ── Tabla horario ── */
.ht-outer { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.ht-table {
    width: 100%; border-collapse: collapse;
    min-width: 620px; table-layout: fixed;
}
.ht-table col.col-hora { width: 90px; }
.ht-table col.col-dia  { width: calc((100% - 90px) / 5); }

.ht-table thead th {
    padding: .5rem .4rem;
    font-size: .65rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em; color: var(--cm);
    background: var(--cf); border-bottom: 1.5px solid var(--cb);
    text-align: center; white-space: nowrap;
}
.ht-table thead th.col-hora { text-align: left; }

.ht-table tbody td {
    border: 1px solid #f1f5f9;
    padding: .3rem .35rem;
    vertical-align: top; font-size: .75rem;
}
.ht-table tbody td.col-hora {
    background: var(--cf); font-weight: 700; font-size: .68rem;
    color: var(--cm); white-space: nowrap;
    padding: .55rem .55rem; vertical-align: middle; text-align: center;
}
.ht-table tbody tr.recreo td {
    background: #fef9c3; text-align: center;
    font-size: .68rem; font-weight: 700; color: #92400e;
    padding: .28rem; border: 1px solid #fde68a;
}

/* Celda editable */
.ht-cell { display: flex; flex-direction: column; gap: .25rem; }
.ht-cell select,
.ht-cell input[type=text] {
    width: 100%; padding: .22rem .35rem;
    border: 1px solid var(--cb); border-radius: 5px;
    font-size: .68rem; color: var(--ct); background: white; outline: none;
    transition: border-color .15s;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap; min-width: 0;
}
.ht-cell select:focus,
.ht-cell input[type=text]:focus { border-color: var(--cs); }
.ht-cell select.conflict { border-color: var(--ce); background: #fff1f2; }
.conflict-tag {
    font-size: .6rem; color: var(--ce); font-weight: 700;
    display: none; align-items: center; gap: .2rem;
}
.conflict-tag.show { display: flex; }

/* Empty */
.hg-empty {
    text-align: center; padding: 3rem 1rem;
    color: var(--cm); font-size: .85rem;
}
.hg-empty i { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: .75rem; }

/* Botón guardar */
.btn-guardar {
    display: inline-flex; align-items: center; gap: .45rem;
    padding: .58rem 1.75rem; border-radius: 9px;
    font-size: .875rem; font-weight: 700;
    background: linear-gradient(135deg, var(--cg), #059669);
    color: white; border: none; cursor: pointer; transition: all .2s;
    white-space: nowrap;
}
.btn-guardar:hover { opacity: .88; transform: translateY(-1px); }
.btn-guardar:disabled { opacity: .6; cursor: not-allowed; transform: none; }

/* Spinner */
.hg-spinner { display: none; text-align: center; padding: 2rem; }
.hg-spinner.show { display: block; }

@media(max-width:768px){
    .grado-info { padding: .75rem 1rem; }
    .ht-table col.col-hora { width: 70px; }
}
</style>
@endpush

@section('content')
<div class="hg-wrap">

    {{-- ══ PANEL IZQUIERDO ══ --}}
    <div>
        <div class="hg-panel mb-3">
            <div class="hg-panel-head">
                <i class="fas fa-sliders-h"></i> Configuración
            </div>
            <div class="hg-panel-body">

                <div class="hg-field">
                    <label class="hg-label">Nivel</label>
                    <select class="hg-select" id="selNivel">
                        <option value="">— Seleccionar —</option>
                        <option value="primaria">Primaria (1° – 6°)</option>
                        <option value="secundaria">Secundaria (7° – 9°)</option>
                    </select>
                </div>

                <div class="hg-field">
                    <label class="hg-label">Grado</label>
                    <select class="hg-select" id="selGrado" disabled>
                        <option value="">— Primero elige nivel —</option>
                    </select>
                </div>

                <div class="hg-field">
                    <label class="hg-label">Sección</label>
                    <select class="hg-select" id="selSeccion" disabled>
                        <option value="">— Primero elige grado —</option>
                    </select>
                </div>

                <div class="hg-field">
                    <label class="hg-label">Jornada</label>
                    <select class="hg-select" id="selJornada">
                        <option value="matutina">Matutina</option>
                        <option value="vespertina">Vespertina</option>
                    </select>
                </div>

                <button type="button" class="btn-load" id="btnCargar">
                    <i class="fas fa-calendar-alt"></i> Cargar Horario
                </button>
            </div>
        </div>

        <div class="hg-panel" id="panelEstudiantes" style="display:none;">
            <div class="hg-panel-head">
                <i class="fas fa-users"></i> Estudiantes
                <span id="estConteo"
                      style="margin-left:auto;background:rgba(255,255,255,.2);
                             padding:.1rem .45rem;border-radius:999px;font-size:.68rem;">0</span>
            </div>
            <div class="hg-panel-body" style="padding:.7rem;">
                <div class="est-list" id="listaEstudiantes"></div>
            </div>
        </div>
    </div>

    {{-- ══ PANEL DERECHO ══ --}}
    <div class="hg-main">

        <div class="hg-card" id="estadoVacio">
            <div class="hg-empty">
                <i class="fas fa-calendar-alt"></i>
                <p>Selecciona un grado, sección y jornada<br>para cargar o crear el horario.</p>
            </div>
        </div>

        <div id="seccionHorario" style="display:none;">

            <div class="grado-info">
                <div style="flex:1;min-width:0;">
                    <div class="grado-info-title" id="infoGradoNombre">—</div>
                    <div class="grado-info-sub">Horario de clases</div>
                </div>
                <span class="gi-chip" id="infoJornada">—</span>
                <span class="gi-chip" id="infoNivel">—</span>
                <span class="gi-chip" id="infoAnio">—</span>
            </div>

            <div class="hg-card">
                <div class="hg-card-head">
                    <div class="hg-card-title">
                        <i class="fas fa-table"></i> Tabla de Horario
                    </div>
                    <div class="conflict-legend">
                        <i class="fas fa-exclamation-triangle" style="color:var(--ce);"></i>
                        Rojo = conflicto de profesor
                    </div>
                </div>
                <div class="ht-outer">
                    <table class="ht-table" id="tablaHorario">
                        <colgroup>
                            <col class="col-hora">
                            <col class="col-dia"><col class="col-dia"><col class="col-dia">
                            <col class="col-dia"><col class="col-dia">
                        </colgroup>
                        <thead id="theadHorario"></thead>
                        <tbody id="tbodyHorario"></tbody>
                    </table>
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;">
                <button type="button" id="btnGuardar" class="btn-guardar">
                    <i class="fas fa-save"></i> Guardar Horario
                </button>
            </div>

        </div>

        <div class="hg-spinner" id="spinner">
            <div class="spinner-border text-primary" style="width:2.5rem;height:2.5rem;"></div>
            <p class="mt-2 text-muted" style="font-size:.82rem;">Cargando horario…</p>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
'use strict';

var GRADOS_DATA = @json($gradosAgrupados);
var PROFESORES  = @json($profesores);
var CSRF        = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
var DIAS_ORDEN  = ['Lunes','Martes','Miércoles','Jueves','Viernes'];

var estadoActual = { gradoId: null, jornada: null, horario: null, materias: [] };

var selNivel   = document.getElementById('selNivel');
var selGrado   = document.getElementById('selGrado');
var selSeccion = document.getElementById('selSeccion');
var selJornada = document.getElementById('selJornada');
var btnCargar  = document.getElementById('btnCargar');
var btnGuardar = document.getElementById('btnGuardar');

/* ── Cascada nivel → grado → sección ── */
selNivel.addEventListener('change', function () {
    var nivel = this.value;
    selGrado.innerHTML   = '<option value="">— Seleccionar grado —</option>';
    selSeccion.innerHTML = '<option value="">— Seleccionar sección —</option>';
    selGrado.disabled    = !nivel;
    selSeccion.disabled  = true;
    if (!nivel) return;

    var porNum = {};
    (GRADOS_DATA[nivel] || []).forEach(function (g) {
        if (!porNum[g.numero]) porNum[g.numero] = [];
        porNum[g.numero].push(g);
    });
    Object.keys(porNum).sort(function(a,b){return a-b;}).forEach(function (n) {
        var o = document.createElement('option');
        o.value = n; o.textContent = n + '° Grado';
        selGrado.appendChild(o);
    });
});

selGrado.addEventListener('change', function () {
    var nivel = selNivel.value;
    var num   = parseInt(this.value);
    selSeccion.innerHTML = '<option value="">— Seleccionar sección —</option>';
    selSeccion.disabled  = !num;
    if (!num) return;

    (GRADOS_DATA[nivel] || []).filter(function(g){ return g.numero === num; })
    .forEach(function (g) {
        var o = document.createElement('option');
        o.value = g.id;
        o.textContent = 'Sección ' + g.seccion;
        o.dataset.seccion     = g.seccion;
        o.dataset.anioLectivo = g.anio_lectivo;
        selSeccion.appendChild(o);
    });
});

/* ── Cargar horario ── */
btnCargar.addEventListener('click', function () {
    var gradoId = selSeccion.value;
    var jornada = selJornada.value;
    if (!gradoId || !jornada) { alert('Selecciona nivel, grado, sección y jornada.'); return; }

    mostrarSpinner(true);
    ocultarHorario();

    var opt     = selSeccion.options[selSeccion.selectedIndex];
    var seccion = opt.dataset.seccion;
    var anio    = opt.dataset.anioLectivo;
    var num     = selGrado.value;
    var nivel   = selNivel.value;

    document.getElementById('infoGradoNombre').textContent = num + '° Grado — Sección ' + seccion;
    document.getElementById('infoJornada').textContent     = ucfirst(jornada);
    document.getElementById('infoNivel').textContent       = ucfirst(nivel);
    document.getElementById('infoAnio').textContent        = anio;

    estadoActual.gradoId = gradoId;
    estadoActual.jornada = jornada;

    Promise.all([
        fetch('/api/horario-grado/'     + gradoId + '/' + jornada, xhr()).then(r=>r.json()),
        fetch('/api/grado-materias/'    + gradoId,                  xhr()).then(r=>r.json()),
        fetch('/api/grado-estudiantes/' + gradoId,                  xhr()).then(r=>r.json()),
    ])
    .then(function (res) {
        estadoActual.horario  = res[0].horario;
        estadoActual.materias = res[1].materias;
        renderTabla(estadoActual.horario, estadoActual.materias);
        renderEstudiantes(res[2].estudiantes);
        mostrarSpinner(false);
        mostrarHorario();
    })
    .catch(function (err) {
        mostrarSpinner(false);
        alert('Error al cargar: ' + err.message);
    });
});

/* ── Render tabla ── */
function renderTabla(horario, materias) {
    var thead = document.getElementById('theadHorario');
    var tbody = document.getElementById('tbodyHorario');
    var dias  = DIAS_ORDEN.filter(function(d){ return horario[d] !== undefined; });

    thead.innerHTML = '<tr><th class="col-hora">Hora</th>'
        + dias.map(function(d){ return '<th>' + d + '</th>'; }).join('') + '</tr>';

    var horas = Object.keys(horario[dias[0]] || {});
    var html  = '';

    horas.forEach(function (hora) {
        if (hora.toUpperCase().includes('RECREO')) {
            html += '<tr class="recreo"><td colspan="' + (dias.length + 1) + '">'
                  + '<i class="fas fa-coffee me-1"></i>' + hora + '</td></tr>';
            return;
        }

        html += '<tr><td class="col-hora">' + hora + '</td>';
        dias.forEach(function (dia) {
            var c = (horario[dia] && horario[dia][hora]) ? horario[dia][hora] : null;
            html += '<td><div class="ht-cell" data-dia="' + esc(dia) + '" data-hora="' + esc(hora) + '">';

            html += '<select class="sel-materia">'
                  + '<option value="">Sin clase</option>'
                  + materias.map(function(m){
                        return '<option value="' + m.id + '"'
                            + ((c && String(c.materia_id)===String(m.id)) ? ' selected' : '') + '>'
                            + esc(m.nombre) + '</option>';
                    }).join('')
                  + '</select>';

            html += '<select class="sel-profesor" data-dia="' + esc(dia) + '" data-hora="' + esc(hora) + '">'
                  + '<option value="">Sin profesor</option>'
                  + PROFESORES.map(function(p){
                        return '<option value="' + p.id + '"'
                            + ((c && String(c.profesor_id)===String(p.id)) ? ' selected' : '') + '>'
                            + esc(p.nombre + ' ' + p.apellido) + '</option>';
                    }).join('')
                  + '</select>';

            html += '<input type="text" class="inp-salon" placeholder="Salón" maxlength="10" value="'
                  + esc(c && c.salon ? c.salon : '') + '">';

            html += '<span class="conflict-tag"><i class="fas fa-exclamation-triangle"></i> Conflicto</span>';
            html += '</div></td>';
        });
        html += '</tr>';
    });

    tbody.innerHTML = html;

    tbody.querySelectorAll('.sel-profesor').forEach(function (sel) {
        sel.addEventListener('change', function () { verificarConflicto(this); });
    });
}

/* ── Verificar conflicto ── */
function verificarConflicto(selEl) {
    var profId = selEl.value;
    var dia    = selEl.dataset.dia;
    var hora   = selEl.dataset.hora;
    var tag    = selEl.closest('.ht-cell').querySelector('.conflict-tag');
    if (!profId) { selEl.classList.remove('conflict'); tag.classList.remove('show'); return; }

    var url = '/superadmin/horarios/' + estadoActual.gradoId + '/' + estadoActual.jornada
            + '/conflicto?profesor_id=' + profId
            + '&dia=' + encodeURIComponent(dia)
            + '&hora=' + encodeURIComponent(hora);

    fetch(url, xhr()).then(r=>r.json()).then(function (data) {
        if (data.conflicto) {
            selEl.classList.add('conflict'); tag.classList.add('show');
            tag.title = 'Ya asignado en: ' + (data.grados || []).join(', ');
        } else {
            selEl.classList.remove('conflict'); tag.classList.remove('show');
        }
    });
}

/* ── Render estudiantes ── */
function renderEstudiantes(lista) {
    var el     = document.getElementById('listaEstudiantes');
    var conteo = document.getElementById('estConteo');
    conteo.textContent = lista.length;

    el.innerHTML = lista.length
        ? lista.map(function (e, i) {
            var ini = (e.nombre1 || '?')[0].toUpperCase();
            return '<div class="est-item">'
                + '<div class="est-av">' + ini + '</div>'
                + '<div style="flex:1;min-width:0;">'
                +   '<div style="font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + esc(e.nombre1 + ' ' + e.apellido1) + '</div>'
                +   '<div style="font-size:.65rem;color:var(--cm);">' + esc(e.dni || '') + '</div>'
                + '</div>'
                + '<span class="est-num">#' + (i+1) + '</span>'
                + '</div>';
        }).join('')
        : '<div style="text-align:center;padding:1rem;color:var(--cm);font-size:.76rem;">Sin estudiantes asignados</div>';

    document.getElementById('panelEstudiantes').style.display = '';
}

/* ══════════════════════════════════════
   GUARDAR — usa fetch con método PUT
   Evita todo el problema de _method
══════════════════════════════════════ */
btnGuardar.addEventListener('click', function () {
    if (!estadoActual.gradoId || !estadoActual.jornada) {
        alert('Carga el horario antes de guardar.');
        return;
    }

    /* Construir objeto horario desde la tabla */
    var horario = JSON.parse(JSON.stringify(estadoActual.horario));

    /* Resetear valores */
    Object.keys(horario).forEach(function (dia) {
        if (!horario[dia]) return;
        Object.keys(horario[dia]).forEach(function (hora) { horario[dia][hora] = null; });
    });

    /* Leer celdas */
    document.querySelectorAll('#tbodyHorario .ht-cell').forEach(function (cell) {
        var dia    = cell.dataset.dia;
        var hora   = cell.dataset.hora;
        var matId  = cell.querySelector('.sel-materia')?.value  || null;
        var profId = cell.querySelector('.sel-profesor')?.value || null;
        var salon  = cell.querySelector('.inp-salon')?.value    || null;
        if (horario[dia] !== undefined) {
            horario[dia][hora] = (matId || profId || salon)
                ? { materia_id: matId, profesor_id: profId, salon: salon }
                : null;
        }
    });

    /* Spinner en botón */
    btnGuardar.disabled = true;
    btnGuardar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando…';

    /* URL de la ruta PUT */
    var url = '/superadmin/horarios/' + estadoActual.gradoId + '/' + estadoActual.jornada;

    /* fetch con método PUT — sin problema de _method */
    fetch(url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ horario: horario }),
    })
    .then(function (r) {
        if (!r.ok) throw new Error('Error ' + r.status);
        return r.json();
    })
    .then(function (data) {
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = '<i class="fas fa-save"></i> Guardar Horario';
        /* Usar el sistema de alertas flotantes del layout */
        if (typeof sysAlert === 'function') {
            sysAlert('success', data.mensaje || 'Horario guardado correctamente');
        } else {
            alert('Horario guardado correctamente');
        }
    })
    .catch(function (err) {
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = '<i class="fas fa-save"></i> Guardar Horario';
        if (typeof sysAlert === 'function') {
            sysAlert('error', 'Error al guardar: ' + err.message);
        } else {
            alert('Error al guardar: ' + err.message);
        }
    });
});

/* ── Helpers ── */
function xhr()  { return { headers: { 'X-Requested-With': 'XMLHttpRequest' } }; }
function mostrarSpinner(s) { document.getElementById('spinner').classList.toggle('show', s); }
function mostrarHorario()  {
    document.getElementById('seccionHorario').style.display = '';
    document.getElementById('estadoVacio').style.display    = 'none';
}
function ocultarHorario()  {
    document.getElementById('seccionHorario').style.display = 'none';
    document.getElementById('estadoVacio').style.display    = '';
}
function ucfirst(s) { return s ? s[0].toUpperCase() + s.slice(1) : s; }
function esc(s) {
    return String(s || '')
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

})();
</script>
@endpush