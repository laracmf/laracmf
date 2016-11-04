<?php

namespace GrahamCampbell\BootstrapCMS\Services;

use Illuminate\Http\Request;

class ConfigurationsService
{
    /**
     * Get environments files names placed in path provided in config/app.php
     *
     * @return array
     */
    public function getEnvironmentsList()
    {
        return array_map(function ($fileName) {
            return explode('.', $fileName)[2];
        }, array_diff(scandir(config('app.env_path')), ['.', '..']));
    }

    /**
     * Get file data.
     *
     * @return array
     */
    public function getEnvironment($name)
    {
        $params = explode("\n", file_get_contents(config('app.env_path') . '/' . $this->getFileName($name)));
        $params = array_filter($params, function($value) { return $value !== ''; });

        $result = [];

        foreach ($params as $param) {
            $keyValue = explode('=', $param);

            if (count($keyValue) >=2) {
                $result[$keyValue[0]] = $keyValue[1];
            }
        }

        return $result;
    }

    /**
     * Save config data into file.
     *
     * @param Request $request
     * @param $name
     *
     * @return bool|int
     */
    public function writeData(Request $request, $name = null)
    {
        $keys = $request->get('keys');
        $values = $request->get('values');
        $formName = $request->get('name');

        if ($name && ($name !== $formName)) {
            unlink(config('app.env_path') . '/' . $this->getFileName($name));
        }

        $file = config('app.env_path') . '/' . $this->getFileName($formName);

        return file_put_contents($file, $this->createAssociations($keys, $values));
    }

    /**
     * Create associations key=value and convert it into string.
     *
     * @param $keys
     * @param $values
     * @return string
     */
    public function createAssociations($keys, $values)
    {
        $result = [];

        for ($i = 0; $i < count($keys); $i++) {
            $result[] = $keys[$i] . '=' . $values[$i];
        }

        return implode("\n", $result);
    }

    /**
     * Delete file from directory.
     *
     * @param $name
     * @return boolean
     */
    public function deleteConfig($name)
    {
        $file = config('app.env_path') . '/' . $this->getFileName($name);

        if (file_exists($file)) {
            return unlink(config('app.env_path') . '/' . $this->getFileName($name));
        }

        return false;
    }

    /**
     * Get environment file name. For example "prod" it converts to .env.prod
     *
     * @param $name
     * @return string
     */
    public function getFileName($name)
    {
        return '.env.' . $name;
    }
}