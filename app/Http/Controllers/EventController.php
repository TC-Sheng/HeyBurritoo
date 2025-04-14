<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Middleware\SlackEvent;
use App\Http\Requests\EventPostRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller {

    public function __construct() {
        $this->middleware( SlackEvent::class, [
            'only' => [ 'store' ]
        ] );

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        Log::info('GET /api/event accessed');
        return response( 'GET /api/event' );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventPostRequest $request
     * @return Response
     */
    public function store(EventPostRequest $request) {
        Log::info('POST /api/event received', [
            'request_data' => $request->all(),
            'ip' => $request->ip()
        ]);

        try {
            $validated = $request->validated();
            
            $event = new Event();
            $event->type = $validated['type'] ?? 'message';
            $event->user = $validated['event']['user'] ?? null;
            $event->channel = $validated['event']['channel'] ?? null;
            $event->text = $validated['event']['text'] ?? null;
            $event->save();

            Log::info('Event saved successfully', ['event_id' => $event->id]);

            return response()->json([
                'status' => 'success',
                'message' => 'Event received and stored',
                'event_id' => $event->id
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error processing event', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit( $id ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update( Request $request, $id ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy( $id ) {
        //
    }
}
