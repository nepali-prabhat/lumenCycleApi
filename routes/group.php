<?php
    $router->post('/groups/user','GroupController@attachUser');
    $router->delete('/groups/user','GroupController@detachUser');

    $router->get('/groups/{id}','GroupController@getGroup');
    $router->post('/groups','GroupController@addGroup');
    $router->delete('/groups/{id}','GroupController@deleteGroup');
