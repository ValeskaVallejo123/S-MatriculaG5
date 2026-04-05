<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsignarEstudiantesGradoSeeder extends Seeder
{
    /**
     * Mapea el campo `grado` (string) de estudiantes al numero+nivel de la tabla grados,
     * luego distribuye los estudiantes en las secciones disponibles de forma equitativa.
     */
    public function run(): void
    {
        // ── Mapa: valor del campo grado => [numero, nivel] ──────────────────
        $mapaGrados = [
            // Primaria
            'Primero'        => [1, 'primaria'],
            'Segundo'        => [2, 'primaria'],
            'Tercero'        => [3, 'primaria'],
            'Cuarto'         => [4, 'primaria'],
            'Quinto'         => [5, 'primaria'],
            'Sexto'          => [6, 'primaria'],
            '6to Grado'      => [6, 'primaria'],
            // Secundaria (I, II, III curso o nombres numéricos)
            'I curso'        => [7, 'secundaria'],
            'Séptimo'        => [7, 'secundaria'],
            'Septimo'        => [7, 'secundaria'],
            '1ro Secundaria' => [7, 'secundaria'],
            'II curso'       => [8, 'secundaria'],
            'Octavo'         => [8, 'secundaria'],
            '2do Secundaria' => [8, 'secundaria'],
            'III curso'      => [9, 'secundaria'],
            'Noveno'         => [9, 'secundaria'],
            '3ro Secundaria' => [9, 'secundaria'],
        ];

        // ── Precarga todos los grados disponibles ────────────────────────────
        // grados[numero][nivel] = [lista de ids por sección]
        $gradosPorNivelNumero = [];
        $gradosDB = DB::table('grados')->where('activo', true)->get();

        foreach ($gradosDB as $g) {
            $gradosPorNivelNumero[$g->nivel][$g->numero][] = $g->id;
        }

        // ── Obtener todos los estudiantes sin grado_id asignado ──────────────
        $estudiantes = DB::table('estudiantes')->whereNull('grado_id')->get();

        $asignados  = 0;
        $omitidos   = 0;

        // Contador de estudiantes por grado_id (para distribución equitativa)
        $contadorPorGrado = DB::table('estudiantes')
            ->whereNotNull('grado_id')
            ->selectRaw('grado_id, COUNT(*) as total')
            ->groupBy('grado_id')
            ->pluck('total', 'grado_id')
            ->toArray();

        foreach ($estudiantes as $est) {
            $gradoStr = trim($est->grado ?? '');

            if (!isset($mapaGrados[$gradoStr])) {
                $omitidos++;
                continue;
            }

            [$numero, $nivel] = $mapaGrados[$gradoStr];

            // Obtener lista de grado_ids disponibles para este nivel+numero
            $ids = $gradosPorNivelNumero[$nivel][$numero] ?? [];

            if (empty($ids)) {
                $omitidos++;
                continue;
            }

            // Elegir la sección con menos estudiantes (distribución equitativa)
            $gradoElegido = null;
            $minAlumnos   = PHP_INT_MAX;

            foreach ($ids as $gid) {
                $cant = $contadorPorGrado[$gid] ?? 0;
                if ($cant < $minAlumnos) {
                    $minAlumnos   = $cant;
                    $gradoElegido = $gid;
                }
            }

            if (!$gradoElegido) {
                $omitidos++;
                continue;
            }

            // Obtener la sección del grado elegido
            $seccion = DB::table('grados')->where('id', $gradoElegido)->value('seccion');

            // Asignar
            DB::table('estudiantes')
                ->where('id', $est->id)
                ->update([
                    'grado_id' => $gradoElegido,
                    'seccion'  => $seccion,
                ]);

            $contadorPorGrado[$gradoElegido] = ($contadorPorGrado[$gradoElegido] ?? 0) + 1;
            $asignados++;
        }

        $this->command->info("✅ {$asignados} estudiantes asignados a grados.");

        if ($omitidos > 0) {
            $this->command->warn("⚠️  {$omitidos} estudiantes omitidos (grado no reconocido o sin sección disponible).");
        }

        // ── Resumen por grado ────────────────────────────────────────────────
        $this->command->line('');
        $this->command->line('  Distribución por grado:');

        $resumen = DB::table('estudiantes')
            ->join('grados', 'grados.id', '=', 'estudiantes.grado_id')
            ->selectRaw('grados.numero, grados.nivel, grados.seccion, COUNT(estudiantes.id) as total')
            ->groupBy('grados.numero', 'grados.nivel', 'grados.seccion')
            ->orderBy('grados.nivel')
            ->orderBy('grados.numero')
            ->orderBy('grados.seccion')
            ->get();

        foreach ($resumen as $r) {
            $this->command->line(
                sprintf('  %d° %s Sección %s → %d estudiantes',
                    $r->numero, ucfirst($r->nivel), $r->seccion, $r->total)
            );
        }
    }
}
