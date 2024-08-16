<?php

namespace App\Http\Controllers;

use App\Models\EventoView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventoViewController extends Controller
{
    public function all(Request $request)
    {
        $limit = $request->query('limit');

        if ($limit){
            $topEventos = DB::table('eventos_views')
            ->select('evento_id', DB::raw('count(evento_id) as views_count'))
            ->groupBy('evento_id')
            ->orderBy('views_count', 'desc')
            ->get();

        $topEventoIds = $topEventos->pluck('evento_id');

        $eventInfos = DB::table('eventos_views')
            ->whereIn('evento_id', $topEventoIds)
            ->select('evento_id', 'info')
            ->distinct('evento_id')
            ->get()
            ->keyBy('evento_id');

        $events = $topEventos->map(function ($event) use ($eventInfos) {
            $infoRecord = $eventInfos->get($event->evento_id);
            if ($infoRecord) {
                $event->info = $infoRecord->info;
            } else {
                $event->info = null;
            }
            return $event;
        });
        }else {

            $topEventos = DB::table('eventos_views')
            ->select('evento_id', DB::raw('count(evento_id) as views_count'))
            ->groupBy('evento_id')
            ->orderBy('views_count', 'desc')
            ->get();

        $topEventoIds = $topEventos->pluck('evento_id');

        $eventInfos = DB::table('eventos_views')
            ->whereIn('evento_id', $topEventoIds)
            ->select('evento_id', 'info')
            ->distinct('evento_id')
            ->get()
            ->keyBy('evento_id');

        $events = $topEventos->map(function ($event) use ($eventInfos) {
            $infoRecord = $eventInfos->get($event->evento_id);
            if ($infoRecord) {
                $event->info = $infoRecord->info;
            } else {
                $event->info = null;
            }
            return $event;
        });


        }

        return response()->json($events);
    }

    public function store(Request $request)
    {
        // Validate the incoming request


        // Create a new view record
        $view = EventoView::create([
            'evento_id' => $request->input('evento_id'),
            'info' => $request->input('info'),
        ]);

        return response()->json($view);
    }
}
