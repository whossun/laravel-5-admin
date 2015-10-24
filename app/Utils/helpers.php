<?php

if (! function_exists('strbool')) {
    /**
     * 转换boolen成字符串
     *
     * @param  boolen  $value
     * @return string
     */
    function strbool($value)
    {
        return $value ? 'true' : 'false';
    }
}
