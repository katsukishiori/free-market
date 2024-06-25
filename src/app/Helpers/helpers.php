<?php

if (!function_exists('sanitize_br')) {
    function sanitize_br($str)
    {
        return nl2br(e($str));
    }
}
