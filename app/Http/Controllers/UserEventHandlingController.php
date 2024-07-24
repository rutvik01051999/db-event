<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class UserEventHandlingController extends Controller
{
    public function index($id){
        try {
          $event = Event::findOrFail($id);
          
        }
        catch(\Exception $e){  

         }
    }
}
