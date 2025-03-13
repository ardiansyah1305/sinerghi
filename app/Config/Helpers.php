<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Helpers extends BaseConfig
{
    /**
     * List of helper files that will be loaded automatically on controller instantiation.
     *
     * @var array
     */
    public $helpers = [
        'status',
        'form',
        'url',
        'html',
    ];
}
