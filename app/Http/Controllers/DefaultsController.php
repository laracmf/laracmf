<?php

namespace GrahamCampbell\BootstrapCMS\Http\Controllers;

class DefaultsController extends AbstractController
{
    /**
     * Fetch all model items
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        /*
         * Fetching data stuff
         */

        return $this->response(
            true,
            [
                'defaults' => [
                    'first'  => 1,
                    'second' => 2,
                    'third'  => 3,
                ]
            ]
        );
    }

    /**
     * Fetch item data
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {
        /*
         * Fetching data stuff
         */

        return $this->response(
            true,
            [
                'default' => [
                    'firstObjectProperty'  => 1,
                    'secondObjectProperty' => 2
                ]
            ]
        );
    }

    /**
     * Create new item
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store()
    {
        /*
         * Store stuff
         */

        return $this->response(
            true,
            [
                'default' => [
                    'firstObjectProperty'  => 1,
                    'secondObjectProperty' => 2
                ]
            ]
        );
    }

    /**
     * Update item
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update($id)
    {
        /*
         * Update stuff
         */
        return $this->response(false, ['error' => 'Default not found']);
    }

    /**
     * Destroy item.
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id)
    {
        /*
         * Destroy stuff
         */
        return $this->response(true);
    }
}
