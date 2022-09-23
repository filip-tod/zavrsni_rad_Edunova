<?php 

class proizvodiController extends Controller
{
    public function patike()
    {
        $this->view->render('javno' . DIRECTORY_SEPARATOR .
                            'patike');
    }

    public function hlacice()
    {
        $this->view->render('javno' . DIRECTORY_SEPARATOR .
                            'hlacice');
    }

    public function dodatna_oprema()
    {
        $this->view->render('javno' . DIRECTORY_SEPARATOR .
                            'dodatna_oprema');
    }

    public function dresovi()
    {
        $this->view->render('javno' . DIRECTORY_SEPARATOR .
                            'dresovi');
    }

}

?>