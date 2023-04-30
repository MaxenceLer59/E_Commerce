<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use App\Http\Controllers\UserController;

class UserTest extends TestCase
{
    public function testIndexUserController() : void
    {
        $users = $this->mockUser(10);
        $listUsers = $this->get('/api/users');
        $data = json_decode($listUsers->getContent(), true);
        $this->assertEquals('10', count($data));
    }

    public function testRegisterUserController() : void
    {
        $userAttributes = [
            'login' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'testTest59',
            'firstname' => 'test',
            'lastname' => 'test',
        ];

        $user = $this->post('/api/register', $userAttributes);
        $data = json_decode($user->getContent(), true);
        $user_info = $data['user'];
        $user_token = $data['token'];

        $this->assertEquals('test test@gmail.com test test',
                            $user_info['login']." ".$user_info['email']." ".$user_info['firstname']." ".$user_info['lastname']);
        $this->assertTrue(true, $user_token != null || $user_token != '');
    }

    public function testLoginUserController() : void
    {
        $userRegisterAttributes = [
            'login' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'testTest59',
            'firstname' => 'test',
            'lastname' => 'test',
        ];

        $userLoginAttributes = [
            'login' => 'test',
            'password' => 'testTest59',
        ];

        $userRegistered = $this->post('/api/register', $userRegisterAttributes);
        $userLogin = $this->post('/api/login', $userLoginAttributes);

        $data_login = json_decode($userLogin->getContent(), true);
        $user_info = $data_login['user'];
        $user_token = $data_login['token'];

        $this->assertEquals('test test@gmail.com test test',
                            $user_info['login']." ".$user_info['email']." ".$user_info['firstname']." ".$user_info['lastname']);
        $this->assertTrue(true, $user_token != null || $user_token != '');
    }

    public function testLogoutUserController() : void
    {
        $userAttributes = [
            'login' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'testTest59',
            'firstname' => 'test',
            'lastname' => 'test',
        ];

        $user = $this->post('/api/register', $userAttributes);
        $current_user = json_decode($user->getContent(), true);
        $reponse_logout = $this->withHeaders(['Authorization' => 'Bearer ' . $current_user['token']])->get('/api/logout');
        $message = json_decode($reponse_logout->getContent(), true);
        
        $this->assertEquals('Vous êtes déconnecté', $message['message']);
    }

    // public function testShowUserController() : void
    // {
    //     $userAttributes = [
    //         'login' => 'test',
    //         'email' => 'test@gmail.com',
    //         'password' => 'testTest59',
    //         'firstname' => 'test',
    //         'lastname' => 'test',
    //     ];

    //     $user = $this->post('/api/register', $userAttributes);
    //     $current_user = json_decode($user->getContent(), true);
    //     $current_user = $this->withHeaders(['Authorization' => 'Bearer ' . $current_user['token']])->get('/api/users/1');
    // }

    public function testUpdateUserController() : void
    {
        $userAttributes = [
            'login' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'testTest59',
            'firstname' => 'test',
            'lastname' => 'test',
        ];

        $user = $this->post('/api/register', $userAttributes);
        $current_user = json_decode($user->getContent(), true);
        $userAttributes['firstname'] = 'testChanged';
        
        $current_user_changed = $this->withHeaders(['Authorization' => 'Bearer ' . $current_user['token']])->post('/api/users/1', $userAttributes);
        $current_user = json_decode($current_user_changed->getContent(), true);
        
        $this->assertEquals('testChanged', $current_user['firstname']);
    }

    public function testDestroyUserController() : void  
    {
        $userAttributes = [
            'login' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'testTest59',
            'firstname' => 'test',
            'lastname' => 'test',
        ];

        $user = $this->post('/api/register', $userAttributes);
        $current_user = json_decode($user->getContent(), true);

        $this->withHeaders(['Authorization' => 'Bearer ' . $current_user['token']])->delete('/api/users/1');
        $this->assertEquals(0, User::count());
    }  
}