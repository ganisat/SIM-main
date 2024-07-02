<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    public function login()
    {
        helper(['form']);
        echo view('login');
    }

    public function loginAuth()
    {
        $session = session();
        $model = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $data = $model->where('username', $username)->first();

        if ($data) {
            $pass = $data['password'];
            if ($password == $pass) {
                $ses_data = [
                    'id' => $data['id'],
                    'username' => $data['username'],
                    'role' => $data['role'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username not Found');
            return redirect()->to('/login');
        }
    }

    public function dashboard()
    {
        $session = session();
        if ($session->get('logged_in')) {
            $role = $session->get('role');
            switch ($role) {
                case 'admin':
                    return view('admin_dashboard');
                case 'guru':
                    return view('guru_dashboard');
                case 'siswa':
                    return view('siswa_dashboard');
                default:
                    return redirect()->to('/login');
            }
        } else {
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
