<?php

namespace Modules\Tags\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Tags\Models\Tag;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Modules\Tags\Models\LogActionsTag;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tags = Tag::with([
            'creator:id,first_name,last_name',
            'logs_actions'
            ])
            ->orderByDesc('id')
            ->simplePaginate(8);

        // Transformamos los elementos para aplanar la estructura manteniedo el tipo Paginated
        $tags->getCollection()->transform(function ($tag) {
            $tag->first_name = $tag?->creator?->first_name ?? '';
            $tag->last_name = $tag?->creator?->last_name ?? '';

            //Mapeo los logs
            $tag->formatted_logs = $tag->logs_actions->map(function ($log) {
                $userName = $log->user 
                    ? trim("{$log->user->first_name} {$log->user->last_name}")
                    : 'Usuario';

                // Formato: "Miércoles 04 de Octubre del 2023 a las 12:14 pm"
                $dateFormatted = ucfirst($log->created_at->locale('es')->isoFormat('dddd DD [de] MMMM [del] YYYY [a las] hh:mm a'));

                $actionText = $log->message ?? 'realizó un cambio en esta etiqueta';

                return [
                    'user' => $userName,
                    'message' => $actionText,
                    'date' => $dateFormatted,
                    'full_text' => "{$userName} {$actionText} el {$dateFormatted}"
                ];
            });
            return $tag;
        });

        return view('tags::index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tags::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color'       => 'nullable|string|max:200',
        ]);

        do {
            $uid = 'TAG' . strtoupper(Str::random(5));
        } while (Tag::where('uid', $uid)->exists());

        //Buscar el team id del usuario 
        $user = User::with('teams')->find(Auth::user()->id);

        if (!$user) {
            throw new InvalidArgumentException("Usuario invalido o no encontrado en la BD");
        }

        $record['uid']        = $uid;
        $record['created_by'] = $user->id;

        $tag = Tag::create($record);

        //Si se creo la categoria
        if ($tag) {
            //Guardar log
            LogActionsTag::create([
                'tag_id'   => $tag->id,
                'user_id'       => $user->id,
                'resource_name' => 'store',
                'section_name'  => 'Agregar Etiqueta',
                'message'       =>  ($user->first_name ?? '') . ' ' . ($user->last_name ?? 'Un empleado') 
                                    . ' creó esta etiqueta el ' 
                                    . (\Carbon\Carbon::parse($tag?->created_at)->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a')),
                'values'        => $tag->toArray(),
            ]);
        }

        return response()->json([
            'message'  => 'Etiqueta creada con éxito',
            'tag' => $tag
        ], 201);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('tags::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('tags::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'color'       => 'nullable|string|max:200',
        ]);

        try {
            $user = Auth::user();
            $tag = Tag::findOrFail($id);

            $oldStatus = (int) $tag->status;

            $tag->name        = $validatedData['name'];
            $tag->description = $validatedData['description'];
            $tag->color       = $validatedData['color'] ?? '#C4C4C4'; // Valor de resguardo por defecto
            $tag->status      = $request?->status ?? 0;
            $tag->save();

            $tagStatus = $tag->status;

            //Guardar log edicion
            LogActionsTag::create([
                'tag_id'   => $tag->id,
                'user_id'       => $user->id,
                'resource_name' => 'update',
                'section_name'  => 'Editar Categoría',
                'message'       =>  ($user->first_name ?? '') . ' ' . ($user->last_name ?? 'Un empleado') 
                                    . ' editó esta categoría el ' 
                                    . (\Carbon\Carbon::now()->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a')),
                'values'        => $tag->toArray(),
            ]);

            $aditionalAction = $oldStatus !== $tagStatus;

            if ($aditionalAction) {
                 //Guardar log activar/desactivar
                 $action = match ($tagStatus) {
                    0 => 'desactivo',
                    1 => 'activó',
                 };

                LogActionsTag::create([
                    'tag_id'        => $tag->id,
                    'user_id'       => $user->id,
                    'resource_name' => 'update',
                    'section_name'  => $action,
                    'message'       =>  ($user->first_name ?? '') . ' ' . ($user->last_name ?? 'Un empleado') 
                                        .' '. $action .' esta categoría el ' 
                                        . (\Carbon\Carbon::now()->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a')),
                    'values'        =>  [
                        'status' => $tagStatus 
                    ],
                ]);
            }

            // 200 http respuesta
            return response()->json([
                'success' => true,
                'message' => 'La etiqueta ha sido actualizada con éxito.'
            ], 200);

        } catch (\Exception $e) {
            \Log::info($e);
            
            return response()->json([
                'success' => false,
                'message' => 'No se pudieron guardar los cambios.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
