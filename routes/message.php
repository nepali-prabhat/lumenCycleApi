<?php

    $router->post('/messages','MessageController@addMessage');
    $router->delete('/messages/{id}','MessageController@deleteMessage');

    $router->get('/messages/{group_id}','MessageController@getMessages');
