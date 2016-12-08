<?php

namespace GrahamCampbell\BootstrapCMS\Services;

class ConfigurationsService
{
    const ENV_NAME = '.env';

    /**
     * Get file data.
     *
     * @return array|bool
     */
    public function getEnvironment()
    {
        if (!$this->fileExists($this::ENV_NAME)) {
            return false;
        }

        $params = explode("\n", file_get_contents(config('app.env_path') . $this::ENV_NAME));
        $params = array_filter(
            $params,
            function ($value) {
                return $value;
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
     *
     * @return bool|int
     */
    public function writeData($data)
    {
        $keys = array_get($data, 'keys', []);
        $values = array_get($data, 'values', []);

        if ($this->fileExists($this::ENV_NAME)) {
            unlink(config('app.env_path') . $this::ENV_NAME);
        }

        return file_put_contents(
            config('app.env_path') . $this::ENV_NAME,
            $this->createAssociations($keys, $values)
        );
    }

    /**
     * Create associations key=value and convert it into string.
     *
     * @param $keys
     * @param $values
     *
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
     * Check whether file exists or not.
     *
     * @param $fileName
     *
     * @return bool
     */
    public function fileExists($fileName)
    {
        return file_exists(config('app.env_path') . $fileName);
    }
}