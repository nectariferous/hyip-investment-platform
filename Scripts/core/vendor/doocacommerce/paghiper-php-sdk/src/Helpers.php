<?php

namespace PagHipperSDK;

class Helpers
{
    /**
     * Transformar decimal para centavos
     *
     * @param $value
     * @return string
     */
    public static function decimalToCents($value)
    {
        $value = number_format($value, 2, '.', '');
        return number_format((float) $value * 100, 0, '.', '');
    }

    /**
     * @param int $value
     * @return float
     */
    public static function centsToDecimal(int $value): float
    {
        return (float) ($value / 100);
    }

    /**
     * @param string $value
     * @return string
     */
    public static function sanitizeNumber($value)
    {
        return preg_replace('/\D/', '', $value);
    }

    /**
     * Camelizes a string.
     *
     * @param string $id A string to camelize
     *
     * @return string The camelized string
     */
    public static function camelize($id)
    {
        return strtr(ucwords(strtr($id, array('_' => ' ', '.' => '_ ', '\\' => '_ '))), array(' ' => ''));
    }
    /**
     * A string to underscore.
     *
     * @param string $id The string to underscore
     *
     * @return string The underscored string
     */
    public static function underscore($id)
    {
        return strtolower(preg_replace(array('/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'), array('\\1_\\2', '\\1_\\2'), str_replace('_', '.', $id)));
    }
}
