<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    /*
     |--------------------------------------------------------------------------
     | Templates
     |--------------------------------------------------------------------------
     |
     | Pagination links are rendered using views to make it simple to change
     | their appearance. This array contains aliases and the view names
     | to use when rendering the links.
     |
     | Within each view, the Pager object will be available as $pager,
     | and the group as $pagerGroup;
     |
     */
    public $templates = [
        'default_full'   => 'CodeIgniter\Pager\Views\default_full',
        'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
        'default_head'   => 'CodeIgniter\Pager\Views\default_head',
        'bootstrap_full' => 'App\Views\pager\bootstrap_full',
    ];

    /*
     |--------------------------------------------------------------------------
     | Items Per Page
     |--------------------------------------------------------------------------
     |
     | The default number of results shown in a single page.
     |
     */
    public $perPage = 20;
}
