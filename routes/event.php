<?php

    $router->get('/events','EventController@getAllEvents');
    $router->get('/events/{id}','EventController@getEvent');
    $router->post('/events','EventController@addEvent');
    $router->put('/events/{id}','EventController@updateEvent');
    $router->delete('/events/{id}','EventController@deleteEvent');

    $router->post('/events/{event_id}/{parti_id}', 'EventController@addParticipant');
    $router->delete('/events/{event_id}/{parti_id}', 'EventController@removeParticipant');
    $router->get('/events/participants/{id}','EventController@getParticipants');

    $router->get('/events/group/{event_id}','EventController@getGroup');


