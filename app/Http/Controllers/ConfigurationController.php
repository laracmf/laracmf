<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationsService;
use App\Http\Requests\ConfigurationRequest;

class ConfigurationController extends AbstractController
{
    /**
     * @var ConfigurationsService
     */
    protected $configurationsService;

    /**
     * ConfigurationController constructor.
     *
     * @param ConfigurationsService $configurationsService
     */
    public function __construct(ConfigurationsService $configurationsService)
    {
        $this->configurationsService = $configurationsService;

        parent::__construct();
    }

    /**
     * Show edit form for passed environment name.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEnvironment()
    {
        if ($env = $this->configurationsService->getEnvironment()) {
            return view('config.edit', ['environment' => $env]);
        }

        return redirect()->back();
    }

    /**
     * Edit configuration file.
     *
     * @param ConfigurationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function editEnvironment(ConfigurationRequest $request)
    {
        $flash = ['level' => 'success', 'message' => 'File successfully edited.'];

        if (!$this->configurationsService->writeData($request->all())) {
            $flash = ['level' => 'error', 'message' => 'Something went wrong, please, resubmit data.'];
        }

        flash()->{$flash['level']}($flash['message']);

        return redirect()->back();
    }
}
