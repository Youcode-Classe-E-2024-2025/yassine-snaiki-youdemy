<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\models\TeachingRequest;
use app\models\User;



class AuthController extends Controller
{
    public function login()
    {
        return $this->render("login");
    }
    public function register()
    {
        return $this->render("register");
    }

    public function handleLogin(Request $request)
    {
        $email = $request->getBody()["email"];
        $password = $request->getBody()["password"];
        $res = User::validateLogin($email,$password);
        if ($res === true) {
            $user = User::findByEmail($email);
            if ($user) {
                if ($user->checkPassword($password)) {
                        $_SESSION['user'] = [
                            'id' => $user->getId(),
                            'email' => $user->getEmail(),
                            'username' => $user->getusername(),
                        ];
                        header('Location: /');
                        exit();
                } else
                    $_SESSION['error'] = "Invalid password";
            } else
                $_SESSION['error'] = "User not found";
        } else
            foreach ($res as $key => $value) {
                $_SESSION[$key] = $value;
            }
        header('Location: /login');
    }

    public function logout()
    {
        session_unset();

        session_destroy();
        header('Location: /login');
        exit;
    }

    public function handleRegister(Request $request)
    {
        $password = $request->getBody()['password'];
        $email = $request->getBody()['email'];
        $confirm_password = $request->getBody()['confirm_password'];
        $username = $request->getBody()['username'];
        $role = $request->getBody()['role'];
        $res = User::validateRegister($email,$password,$confirm_password, $username);
        if ($res === true) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $user = new User($email,$password,$username);
            if ($user->save()){
                if($role==='teacher'){
                    $teachingRequest = new TeachingRequest($user->getId());
                    $teachingRequest->save();
                }
                header('Location: /login');
                exit;
            }
        }else {
            foreach($res as $key => $value) {
                $_SESSION[$key] = $value;
            }
            header('Location: /register');
        }
    }
}