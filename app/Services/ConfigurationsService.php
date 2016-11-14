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
        return array_map(
            function ($fileName) {
                return explode('.', $fileName)[2];
            },
            array_diff(scandir(config('app.env_path')), ['.', '..'])
        );
    }

    /**
     * Get file data.
     *
     * @return array|bool
     */
    public function getEnvironment($name)
    {
        if (!$this->fileExists($name)) {
            return false;
        }

        $params = explode("\n", file_get_contents(config('app.env_path') . '/' . $this->getFileName($name)));
        $params = array_filter(
            $params,
            function ($value) {
                return $value !== '';
            }
        );

        $result = [];

        foreach ($params as $param) {
            $keyValue = explode('=', $param);

            if (count($keyValue) >= 2) {
                $result[$keyValue[0]] = $keyValue[1];
            }
        }

        return $result;
    }

    /**
     * Save config data into file.
     *
     * @param $data
     * @param $name
     *
     * @return bool|int
     */
    public function writeData($data, $name = null)
    {
        $keys = array_get($data, 'keys', []);
        $values = array_get($data, 'values', []);
        $formName = array_get($data, 'name', '');

        if ($name && ($name !== $formName) && $this->fileExists($name)) {
            unlink(config('app.env_path') . '/' . $this->getFileName($name));
        }

        return file_put_contents(
            config('app.env_path') . '/' . $this->getFileName($formName),
            $this->createAssociations($keys, $values)
        );
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

    /**
     * Check whether file exists or not.
     *
     * @param $fileName
     *
     * @return bool
     */
    public function fileExists($fileName)
    {
        return file_exists(config('app.env_path') . '/' . $this->getFileName($fileName));
    }
}