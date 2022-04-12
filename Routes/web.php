<?php

// Add the routes
$router->add('', [ 'controller' => 'Home', 'action' => 'index' ]);
$router->add('vue', [ 'controller' => 'Vue', 'action' => 'index' ]);

$router->add('splendidfood', [ 'namespace' => 'SplendidFood', 'controller' => 'SplendidFood', 'action' => 'index' ]);
$router->add('splendidfood/products', [ 'namespace' => 'SplendidFood', 'controller' => 'Products', 'action' => 'index' ]);
$router->add('splendidfood/past-orders', [ 'namespace' => 'SplendidFood', 'controller' => 'PastOrders', 'action' => 'index' ]);

// $router->add('{controller}/{action}');
// $router->add('{controller}/{id:\d+}/{action}');
// $router->add('admin/{controller}/{action}', [ 'namespace' => 'Admin' ]);
