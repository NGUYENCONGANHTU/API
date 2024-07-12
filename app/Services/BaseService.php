<?php
namespace App\Services;

abstract class BaseService
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->boot();
    }
}