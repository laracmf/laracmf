<?php

namespace GrahamCampbell\BootstrapCMS\Http\Controllers;

use GrahamCampbell\BootstrapCMS\Services\ConfigurationsService;
use Illuminate\Http\Request;
use GrahamCampbell\BootstrapCMS\Http\Requests\ConfigutationRequest;

/**
 * This is the comment controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
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
     * Show all current environments
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEnvironments()
    {
        return view('config.show', ['environments' => $this->configurationsService->getEnvironmentsList()]);
    }

    /**
     * Show edit form for passed environment name.
     *
     * @param string $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditForm($name)
    {
        return view('config.edit', [
            'environment' => $this->configurationsService->getEnvironment($name),
            'name' => $name
        ]);
    }

    public function showCreateForm()
    {
        return view('config.create');
    }

    /**
     * Edit configuration file.
     *
     * @param ConfigutationRequest $request
     * @param $name
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function editEnvironment(ConfigutationRequest $request, $name)
    {
        $flash = ['level' => 'success', 'message' => 'File successfully edited.'];

        if (!$this->configurationsService->writeData($request, $name)) {
            $flash = ['level' => 'error', 'message' => 'Something went wrong, please, resubmit data.'];
        }

        flash()->{$flash['level']}($flash['message']);

        return redirect()
            ->route('show.environments.list', ['environments' => $this->configurationsService->getEnvironmentsList()]);
    }

    /**
     * Create new config file
     *
     * @param ConfigutationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createEnvironment(ConfigutationRequest $request)
    {
        $flash = ['level' => 'success', 'message' => 'File successfully created.'];

        if (!$this->configurationsService->writeData($request)) {
            $flash = ['level' => 'error', 'message' => 'Something went wrong, please, resubmit data.'];
        }

        flash()->{$flash['level']}($flash['message']);

        return redirect()
            ->route('show.environments.list', ['environments' => $this->configurationsService->getEnvironmentsList()]);
    }

    /**
     * Delete config file
     *
     * @param $name
     */
    public function deleteEnvironment($name)
    {
        $response = $this->configurationsService->deleteConfig($name);

        $flash = ['level' => 'success', 'message' => 'File successfully deleted.'];

        if (!$response) {
            $flash = ['level' => 'error', 'message' => 'There is no file with name ' . $name];
        }

        flash()->{$flash['level']}($flash['message']);
    }
}
