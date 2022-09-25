<?php 

class OnamaController extends Controller
{
    public function index()
    {
        $this->view->render('javno' . DIRECTORY_SEPARATOR .
                            'onama');
    }
}

?>