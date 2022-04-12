<?php
namespace Core;
/**
 * Base controller
 * abstract class are non-object classes creates object that extends this class
 */

 abstract class Controller
 {
     /**
      * Parameters from the matched route
      * @var array
      */

    protected $route_params = [];

    /**
     * Class constructor
     * @param array $route_params Parameters from the route
     * @return void
     */

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    public function __call($name,  $args)
    {
        $method = "{$name}Action";
        if(method_exists($this, $method))
        {
            if($this->before() !== false)
            {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        }
        else
        {
            // echo "Method $method not found in controller ".get_class($this);
            throw new \Exception("Method $method not found in controller ".get_class($this));
        }
    }

    /**
     * Before filter - call before an action method
     */
    protected function before(){}

    /**
     * After filter - call after an action method.
     */
    protected function after(){}
 }