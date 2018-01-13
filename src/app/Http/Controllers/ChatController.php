<?php

namespace App\Http\Controllers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use peeto\DarkChat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class ChatController extends Controller {

    protected $config;
    
    public function setConfig($config) {
        $this->config = $config;
    }
    
    protected function load() {
        DarkChat\Chat::load([
            'config' => $this->config,
            'route' => 'chat',
            'xml_message_route' => 'chatxml',
            'xml_send_message_route' => 'chatxml'
        ]);
    }
    
    protected function getOutput() {
        ob_start();
        $this->load();
        return ob_get_clean();
    }
    
    public function showChat($config) {
        $this->config = $config;
        $data = $this->getOutput();
        return view('chat', ['data'  => $data]);
    }

    public function showXmlChat($config) {
        $this->config = $config;
        $data = $this->getOutput();
        return response()->view('chatxml', ['data'  => $data])->header('Content-Type', 'text/xml');
    }

}
