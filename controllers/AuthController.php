<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\models\TeachingRequest;
use app\models\User;



class AuthController extends Controller
{

    public function login($request)
    {
        if($request->getRole() !== 'visitor'){
            header('Location: /');
            exit;
        }
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        
        return $this->render("login",[
            'csrfToken' => $_SESSION['csrf_token']
        ]);
    }
    public function register($request)
    {
        if($request->getRole() !== 'visitor'){
            header('Location: /');
            exit;
        }
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $this->render("register",[
            'csrfToken' => $_SESSION['csrf_token']
        ]);
    }

    
    public function handleLogin(Request $request)
    {
        if(!isset($request->getBody()['email']) || !isset($request->getBody()['password']) || !isset($request->getBody()['csrf_token'])){
            header('Location: /login');
            exit;
        }
        $csrf_token = $request->getBody()["csrf_token"];
        if($csrf_token !== $_SESSION['csrf_token']){
            header('Location: /404');
            exit;
        }
        $email = $request->getBody()["email"];
        $password = $request->getBody()["password"];
        $res = User::validateLogin($email,$password);
        if ($res === true) {
            $user = User::findByEmail($email);
            if ($user) {

                if ($user->checkPassword($password) && $user->getIsactive() == true) {
                        $_SESSION['user'] = [
                            'id' => $user->getId(),
                            'email' => $user->getEmail(),
                            'username' => $user->getusername(),
                            'role' => $user->getRole(),
                            'isactive' => $user->getIsactive()
                        ];
                    
                        if($user->getRole() === 'admin')
                        header('Location: /admin/dashboard');
                        else if($user->getRole() === 'teacher')
                        header('Location: /');
                        else header('Location: /');
                        exit();
                } else if ($user->getIsactive() == false) {
                    $_SESSION['error'] = 'account is suspended';
                }else
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
        header('Location: /');
        exit;
    }

    public function handleRegister($request)
    {
        if(!isset($request->getBody()['email']) || !isset($request->getBody()['password']) || !isset($request->getBody()['confirm_password']) || !isset($request->getBody()['username']) || !isset($request->getBody()['role'])|| !isset($request->getBody()['csrf_token'])){
            header('Location: /register');
            exit;
        }
        $csrf_token = $request->getBody()["csrf_token"];
        if($csrf_token !== $_SESSION['csrf_token']){
            header('Location: /404');
            exit;
        }
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
                    $teachingRequest = new TeachingRequest(null,$user->getId());
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