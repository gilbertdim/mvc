<?php

namespace Core;

class Router
{
    # Associative array of routes (the routing table)
    protected $routes = [];

    # Parameters from the matched route
    # @var array
    protected $params = [];

    /**
     * Add a route to the routing table
     * @param string $route the route URL
     * @param class $controller The Controller to use
     * @param
     * @param array $params Parameters (controller, action, etc.)
     */
    public function add($route, $params = [])
    {
        // $this->routes[$route] = $params;
        
        // Convert the route to a regular expression; escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables e.g. (controller)
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expression e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case insensitive flag
        $route = "/^$route$/i";

        $this->routes[$route] = $params;
    }

    # return the list of added routes
    public function getRoutes()
    {
        return $this->routes;
    }

    # Match the route to the routes in the routing table, setting the $params property if a route is found.
    # @param string $url the route url
    # @return boolean true if a match found, false othewise
    public function match($url)
    {
        // $reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";
        // if(preg_match($reg_exp, $url, $matches))
        // {
        //     $params = [];
        //     foreach($matches as $key => $value)
        //         if(is_string($key)) $params[$key] = $value;

        //     $this->params = $params;
        //     return true;
        // }
        
        foreach($this->routes as $route => $params)
        {
            if(preg_match($route, $url, $matches))
            {
                // Get named capture group values
                foreach($matches as $key => $match)
                {
                    if(is_string($key)) $params[$key] = $match;
                }

                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);
        
        if($this->match($url))
        {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            // $controller = "App\Controllers\\$controller";
            $controller = $this->getNamespace().$controller;

            if(class_exists($controller))
            {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if(preg_match('/action$/i', $action) == 0)
                {
                    $controller_object->$action();
                }
                else
                {
                    // echo "Method $action (in controller $controller) not found";
                    throw new \Exception("Method $action in controller $controller cannot be directly - remove the Action suffix to call this method");
                }
            }
            else
            {
                throw new \Exception("Controller class $controller not found");
            }
        }
        else
        {
            throw new \Exception('No route matched.', 404);
        }
    }

    // Convert the string with hyphens to StudlyCaps
    // e.g. post-authors -> PostAuthors
    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    // Convert the string with hyphens to camelCase
    // e.g. add-new -> addNew
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    # Get the currently matched parameters
    public function getParams()
    {
        return $this->params;
    }

    /**
     * A URL of the format localhost/?page (one variable name, no value) won't work however
     * (NB. The .htaccess file converts the first ? to a & when it's passed through to the $_SERVER variable)/
     * @param string $url The full URL
     * @return string the URL with the query string variables removed
     */
    protected function removeQueryStringVariables($url)
    {
        if($url != '')
        {
            $parts = explode('&', $url, 2);

            if(strpos($parts[0], '=') === false)
            {
                $url = $parts[0];
            }
            else
            {
                $url = '';
            }
        }

        return $url;
    }
    
    /**
     * Get the namespace for the controller class.
     * The namespace defined in the route parameters is added if present
     * @return string The request URL
     */
    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';
        if(array_key_exists('namespace', $this->params))
        {
            $namespace .= $this->params['namespace'].'\\';
        }
        return $namespace;
    }
}