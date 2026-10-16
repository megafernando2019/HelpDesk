<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\DB;

trait HelpDeskUtils
{
    /**
     * Función para obtener inicales del nombre del empleado
     * @param string
     **/
    public function getInitials(string $name): string
    {
        $name = preg_replace('/\s+/', ' ', trim($name));
        $parts = explode(' ', $name);
        $acount = count($parts);

        $initalName = $acount > 0 ? mb_strtoupper(mb_substr($parts[0], 0, 1)) : '';
        $initialLastName = $acount > 2 ? mb_strtoupper(mb_substr($parts[$acount - 2], 0, 1)) : ($acount > 1 ? mb_strtoupper(mb_substr($parts[1], 0, 1)) : '');

        return $initalName . $initialLastName;
    }

     /**
      *
      * @param array $data
      * @param Request $request
      * @param string $token_req
      */
    public static function send_mail(array $data, $request, $token_req = null)
    {
        if ($token_req) {
            $token = $token_req;
        } else {
            $token = $request->session()->get('umo.session.token');
        }

        $curl = curl_init();

        $body = [
            'to'      => $data['to'] ?? '',
            'subject' => $data['subject'] ?? '',
            'body'    => $data['body'] ?? '',
            'tags'    => json_encode($data['tags'] ?? []),
            'user'    => $data['user'] ?? '',
        ];

        // --- MANEJO DE CC (Formato para cURL Multipart) ---
        if (!empty($data['cc'])) {
            $ccList = is_array($data['cc']) ? $data['cc'] : explode(',', $data['cc']);
            $ccList = array_map('trim', array_filter($ccList));

            // Si es más de un correo, desglosamos como cc[0], cc[1] O enviamos como string unificado
            // Para compatibilidad total con la API, asignamos los índices explícitos
            foreach (array_values($ccList) as $i => $email) {
                $body["cc[$i]"] = $email;
            }
        } else {
            $body['cc'] = '';
        }

        // --- MANEJO DE ARCHIVOS ADJUNTOS ---
        if (!empty($data['attach'])) {
            foreach ((array)$data['attach'] as $i => $pdf) {
                if (file_exists($pdf)) {
                    $body["attach[$i]"] = new \CURLFile(
                        realpath($pdf),
                        'application/pdf',
                        basename($pdf)
                    );
                }
            }
        }

        $headers = [
            "Authorization: Bearer {$token}",
            "Content-Type: multipart/form-data",
        ];

        curl_setopt_array($curl, [
            CURLOPT_URL            => config('mtmail.endpoint'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $headers,
        ]);

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return [
                'success' => false, 
                'error'   => $err
            ];
        }

        return json_decode($response, true);
    }

    /**
     * Obtiene el ID del usuario al que corresponde la asignación por carrusel y carga.
     */
    public function getNextAssignedUserId(int $teamId): ?int
    {
        // Statuses que consideramos "activos","en proceso" o "Cancelados"
        $closedStatusIds = [4, 5, 6];

        // Obtener todos los miembros del equipo
        // Ajusta la relación o consulta según cómo relacionas los usuarios con los equipos en tu sistema
        $teamUsers = User::whereHas('teams', function ($query) use ($teamId) {
            $query->where('teams.id', $teamId);
        })->pluck('id')->toArray();

        if (empty($teamUsers)) {
            return null; // Si el equipo no tiene miembros
        }

        // Obtener la carga actual de tickets activos por usuario del equipo
        $userLoads = DB::table('tickets_users_assignations as us')->select('us.user_id', DB::raw('COUNT(*) as total_tickets'))
            ->join('tickets', 'tickets.id', '=', 'us.ticket_id')
            ->whereIn('us.user_id', $teamUsers)
            ->whereNotIn('tickets.status_id', $closedStatusIds)
            ->groupBy('us.user_id')
            ->pluck('total_tickets', 'us.user_id')
            ->toArray();

        // Asegurar que todos los miembros tengan una entrada en el array de cargas (incluso con 0)
        $candidateLoads = [];
        foreach ($teamUsers as $userId) {
            $candidateLoads[$userId] = $userLoads[$userId] ?? 0;
        }

        // Determinar cuál es la menor cantidad de tickets en este momento
        $minLoad = min($candidateLoads);

        \Log::info('Cantidad minima '. $minLoad);

        // Filtrar a los candidatos que tienen esa carga mínima (los "empatados")
        $candidates = array_keys(array_filter($candidateLoads, fn($load) => $load === $minLoad));

        if (count($candidates) === 1) {
            return $candidates[0];
        }

        // Desempate por Carrusel: Buscar cuál fue la última asignación dentro de este grupo de candidatos
        $lastAssignation = DB::table('tickets_users_assignations')
            ->whereIn('user_id', $candidates)
            ->latest('id')
            ->first();

        if (!$lastAssignation) {
            return $candidates[0];
        }

        //Tomar el siguiente en la lista respetando el turno
        $currentIndex = array_search($lastAssignation->user_id, $candidates);
        $nextIndex = ($currentIndex === false || $currentIndex === count($candidates) - 1) ? 0 : $currentIndex + 1;

        return $candidates[$nextIndex];
    }

    public function getUserBotHelpDesk()
    {
        return DB::table('users')->where('id_sso', 'SYSTEM_BOT_01')->first();
    }
}
