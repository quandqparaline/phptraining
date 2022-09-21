<?php
require_once('controllers/base_controller.php');

class defaultController extends BaseController
{
    public function __construct()
    {
        $this->folder = 'default';
    }

    public function index()
    {
        isLoggedIn();
        return $this->render('index');
    }
}