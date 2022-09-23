<?php 

class onamaController extends Controller
{
    public function index()
    {
        $this->view->render('javno' . DIRECTORY_SEPARATOR .
                            'onama');
    }
}

?>