<?php

require_once('libraries/Controller.php');
require_once('libraries/Session.php');

require_once('models/LoginModel.php');

class LoginController extends Controller
{
    private $model;
    private $poemOneId, $poemTwoId;

    public function __construct()
    {
        parent::__construct();

        $this->model = new LoginModel();

        // TODO: these will be set by the admin
        // from the administration panel
        $this->poemOneId = 4;
        $this->poemTwoId = 1;
        $this->code_cap();
        $this->view->poemOne = $this->packPoem(
            $this->model->loadPoemHeader($this->poemOneId),
            $this->model->loadPoemBody($this->poemOneId)
        );

        $this->view->poemTwo = $this->packPoem(
            $this->model->loadPoemHeader($this->poemTwoId),
            $this->model->loadPoemBody($this->poemTwoId)
        );
    }

    public function index()
    {
        Session::set('current_page', 'login');

        $this->view->render('login/index');
    }

    function generateRandomString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function code_cap()
    {
        $var = $this->generateRandomString();
        setcookie("captcha",$var,0,"/");

        $this->view->codeCap = imagecreate(100, 30);

        // White background and blue text
        $bg = imagecolorallocate($this->view->codeCap, 255, 255, 255);
        $textcolor = imagecolorallocate($this->view->codeCap, 0, 0, 255);
        // Write the string at the top left
        imagestring($this->view->codeCap, 5, 0, 0, $var, $textcolor);

        // Output the image

        imagepng($this->view->codeCap);
        imagedestroy($this->view->codeCap);
    }

    public function connect()
    {
        return $this->model->verifyUser();
    }

    public function sign_up()
    {
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password1 = $_POST["password"];
        $password2 = $_POST["repeat-password"];
        $captcha = $_POST['captcha'];
        $captchaSession = $_COOKIE["captcha"];
        if ($this->model->verifyUserReg($email, $username)) {
            if ($password2 == $password1) {
                if ($captcha == $captchaSession) {
                    return $this->model->register();
                } else {
                    Session::set('captcha-wrong', 'Sorry! The captcha code is incorrect.');
                    return false;
                }
            } else {
                Session::set('password-not-same', 'Sorry! The passwords must be equals.');
                return false;
            }
        } else {

            return false;
        }
    }

    public function forgot()
    {
        $email = $_POST["email"];
        return $this->model->emailME($email);
    }

    public function disconnect()
    {
        Session::destroy();
    }

    private function packPoem($header, $body)
    {
        $poem['title'] = $header['POEM_TITLE'];
        $poem['author_name'] = $header['AUTHOR_NAME'];
        $poem['language'] = ($header['LANGUAGE'] === 'en' ? 'gb' : $header['LANGUAGE']);
        $poem['link'] = 'poem/' . $header['LANGUAGE'] . '/' .
            str_replace(' ', '-', $poem['title']);
        $poem['author_link'] = 'author/' .
            str_replace(' ', '-', $poem['author_name']);
        $poem['content'] = $body['POEM_CONTENT'];

        return $poem;
    }


}