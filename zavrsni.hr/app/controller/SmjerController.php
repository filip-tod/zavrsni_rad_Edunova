<?php

class SmjerController extends Controller
{

    private $putanja='privatno' . 
    DIRECTORY_SEPARATOR . 'smjer' . 
    DIRECTORY_SEPARATOR;

    public function index()
    {
        // echo 'Hello Smjer';
        //$view = new View(); - izvučeno u nadklasu
        $this->view->render($this->putanja . 'index',[
            'grad'=>'Osijek',
            'brojevi'=>[
                1,4,7,8
            ]
        ]);
    }
}