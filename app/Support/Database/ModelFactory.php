<?php

namespace Confee\Support\Database;

use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;
use Faker\Factory as FakerFactory;

/**
 * Class ModelFactory
 * @package Confee\Support\Database
 */
abstract class ModelFactory
{
    /**
     * @var string
     */
    protected $model;

    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var Generator
     */
    protected $faker;

    /**
     * ModelFactory constructor.
     */
    public function __construct()
    {
        $this->factory = app()->make(Factory::class);
        $this->faker = FakerFactory::create(app()->getLocale());
    }

    public function define()
    {
        $this->factory->define($this->model, function() {
            return $this->fields();
        });
    }

    /**
     * @return array
     */
    abstract protected function fields();
}