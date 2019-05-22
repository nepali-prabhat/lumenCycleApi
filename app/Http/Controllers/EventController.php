<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
class EventController extends Controller
{
    public function addEvent(Request $request){
        $this->validate($request,[
            "name"=>"required",
            "start_date_time"=>"required",
            "end_date_time"=>"required",
            "host"=>"required",
            "completed"=>"required",
        ]);
        $values = json_encode($request->all());
        $values_decoded = json_decode($values,true);
        $values_decoded['completed'] = (bool) $values_decoded['completed'];
        $event = Event::create($values_decoded);
        return $event;
    }
    public function getEvent($id){
        $event = Event::findOrFail($id);
        $host = $event->host()->get();
        $event['host']= $host[0];
        return $event;
    }
    public function getAllEvents(Request $request){
        // $this->validate($request,[
        //     'host'=>'boolean'
        // ])
        if($request->has('host')){
            $host = (bool)$request->input('host');
            if($host){
                $events = Event::with('host')->get();
                return $events;
            }
        }
        $events = Event::all();
        return $events;
    }
    public function addParticipant($event_id,$parti_id){
        $event = Event::findOrFail($event_id);
        $event->participants()->syncWithoutDetaching($parti_id);
        return [
            'msg'=>'participant attached.'
        ];
    }
    public function removeParticipant($event_id,$parti_id){
        $event = Event::findOrFail($event_id);
        $event->participants()->detach($parti_id);
        return [
            'msg'=>'participant detached.'
        ];
    }
    public function getParticipants($id){
        $events = Event::with('participants')->get();
        foreach($events as $event){
            if($event->id == $id){
                return $event->participants;
            }
        }
        abort(404);
    }
    public function updateEvent($id,Request $request){
        $event = Event::findOrFail($id);
        if($request->has('name')){
            $event['name']= $request->input('name');
        }
        if($request->has('start_date_time')){
            $event['start_date_time']= $request->input('start_date_time');
        }
        if($request->has('end_date_time')){
            $event['end_date_time']= $request->input('end_date_time');
        }
        if($request->has('host')){
            $event['host']= $request->input('host');
        }
        if($request->has('completed')){
            $event['completed']= $request->input('completed');
        }
        $event->save();
        return $event;
    }
    public function deleteEvent($id){
        $event = Event::findOrFail($id);
        $name = $event->name;
        $event->delete();
        return [
            "msg"=>"Deleted $id. $name"
        ];
    }

    public function getGroup($event_id){
        $event = Event::findOrFail($event_id);
        $event->group;
        return $event;
    }
}
