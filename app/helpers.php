<?php

if (!function_exists('composer'))
{
    /**
     * Reads an entry from composer.json
     *
     * @param string $key the desired key
     * @param mixed $default the default value
     * @return mixed the value from composer.json entry
     */
    function composer($key, $default)
    {
        $file = base_path('composer.json');
        $json = json_decode(file_get_contents($file), true);

        if (!array_key_exists($key, $json) || !$json[$key]) {
            return $default;
        }

        return $json[$key];
    }
}
