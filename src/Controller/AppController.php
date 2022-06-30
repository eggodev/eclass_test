<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        // #eggodev -> agrego el componente que gestionará el login de los usuarios para ingresar al sistema
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'authorize' => 'Controller',
            'authError' => 'No está autorizado para acceder a esa ubicación...',
        ]);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    // #eggodev -> agrego un callback beforeFilter que registra al usuario logueado para verificar sesiones activas
    public function beforeFilter(Event $event)
    {
        $this->set('current_user', $this->Auth->user());
    }

    // #eggodev -> agrego la funcion que controla los niveles de autorización según el rol
    public function isAuthorized($user)
    {
        // Admin allowed anywhere
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }

        // 'user' allowed in specific actions
        if (isset($user['role']) && $user['role'] === 'usuario') {

            $allowedActions = ['index', 'logout', 'view'];
            if (in_array($this->request->action, $allowedActions)) {
                return true;
            }
        }
        return false;
    }
}
