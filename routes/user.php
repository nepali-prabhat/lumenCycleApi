<?php
    $router->get('/users','UserController@getAllUsers');
    $router->get('/users/{id}','UserController@getUserById');
    $router->post('/users','UserController@addUser');
    $router->put('/users/{id}','UserController@updateUser');
    $router->delete('/users/{id}','UserController@deleteUser');

    $router->get('/users/hosted/{id}','UserController@getHostedEvents');
    $router->get('/users/participated/{id}','UserController@getParticipatedEvents');
