<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GrahamCampbell\Binput\Facades\Binput;
use App\Facades\EventRepository;
use GrahamCampbell\Credentials\Facades\Credentials;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Services\EventsService;

class EventController extends AbstractController
{
    /**
     * @var EventsService
     */
    protected $eventService;

    /**
     * EventController constructor.
     * @param EventsService $eventsService
     */
    public function __construct(EventsService $eventsService)
    {
        parent::__construct();
        $this->eventService = $eventsService;
    }

    /**
     * Display a listing of the events.
     *
     * @return View
     */
    public function index()
    {
        $events = EventRepository::paginate();
        $links = EventRepository::links();

        return view('events.index', ['events' => $events, 'links' => $links]);
    }

    /**
     * Show the form for creating a new event.
     *
     * @return View
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a new event.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $input = array_merge(['user_id' => Credentials::getuser()->id], Binput::only([
            'title', 'location', 'date', 'body',
        ]));

        $val = EventRepository::validate($input, array_keys($input));
        if ($val->fails()) {
            return redirect()->route('events.create')->withInput()->withErrors($val->errors());
        }

        $input['date'] = Carbon::createFromFormat(config('date.php_format'), $input['date']);

        $event = EventRepository::create($input);

        return redirect()->route('events.show', ['events' => $event->id])
            ->with('success', trans('messages.event.store_success'));
    }

    /**
     * Show the specified event.
     *
     * @param int $id
     *
     * @return View
     */
    public function show($id)
    {
        $event = EventRepository::find($id);
        $this->eventService->checkEvent($event);

        return view('events.show', ['event' => $event]);
    }

    /**
     * Show the form for editing the specified event.
     *
     * @param int $id
     *
     * @return View
     */
    public function edit($id)
    {
        $event = EventRepository::find($id);
        $this->eventService->checkEvent($event);

        return view('events.edit', ['event' => $event]);
    }

    /**
     * Update an existing event.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $input = Binput::only(['title', 'location', 'date', 'body']);

        $val = $val = EventRepository::validate($input, array_keys($input));
        if ($val->fails()) {
            return redirect()->route('events.edit', ['events' => $id])->withInput()->withErrors($val->errors());
        }

        $input['date'] = Carbon::createFromFormat(config('date.php_format'), $input['date']);

        $event = EventRepository::find($id);
        $this->eventService->checkEvent($event);

        $event->update($input);

        return redirect()->route('events.show', ['events' => $event->id])
            ->with('success', trans('messages.event.update_success'));
    }

    /**
     * Delete an existing event.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = EventRepository::find($id);
        $this->eventService->checkEvent($event);

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', trans('messages.event.delete_success'));
    }
}
