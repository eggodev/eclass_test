<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // #eggodev -> agrego la logica para filtrar los registros si hay búsqueda
        if ($this->request->is('post')) {
            $this->conditions = array();

            $u = $this->request->getData('Search');
            $userQuery = "(users.name LIKE '%$u%' OR users.username LIKE '%$u%' OR users.email LIKE '%$u%')";

            $r = $this->request->getData('perfil');
            $roleQuery = $r !== '' && $r !== '&' ? "users.role = '$r'" : 1;

            $s = $this->request->getData('estado');
            $statusQuery = $s !== '' && $s !== '$' ? "users.status = '$s'" : 1;

            $conditions = $userQuery . ' AND ' . $roleQuery . ' AND ' . $statusQuery;
            $this->conditions = array($conditions);
            $this->paginate['conditions'] = $this->conditions;
            $users = $this->paginate();
            $this->set('users', $users);
        } else {
            $users = $this->paginate($this->Users);
            $this->set(compact('users'));
        }
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('El usuario ha sido registrado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El usuario no pudo ser registrado. Por favor, intente de nuevo.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('El usuario ha sido actualizado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El usuario no pudo ser actualizado. Por favor, intente de nuevo.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        $userLogged = $this->Auth->user();

        if ($user['id'] === $userLogged['id']) {
            $this->Flash->error(__('El usuario no puede auto-eliminarse.'));
        } else {
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('El usuario ha sido eliminado.'));
            } else {
                $this->Flash->error(__('El usuario no pudo eliminarse. Por favor, intente de nuevo.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    // #eggodev -> función que gestiona la autenticación de los usuarios
    public function login()
    {
        if ($this->request->is('post')) {
            $error = 'Usuario inválido o contraseña incorrecta, intente de nuevo';
            if (!filter_var($this->request->data['username'], FILTER_VALIDATE_EMAIL) === false) {
                $this->Auth->setConfig('authenticate', [
                    'Form' => ['fields' => ['username' => 'email', 'password' => 'password']]
                ]);
                $this->Auth->constructAuthenticate();
                $this->request->data['email'] = $this->request->data['username'];
                unset($this->request->data['username']);
            }

            $user = $this->Auth->identify();

            if ($user) {
                if ($user['status']) {
                    $this->Auth->setUser($user);
                    $this->Flash->success(__('Bienvenido ' . ucfirst($user['name'])));
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $error = 'Usuario inactivo, consulte con el administrador';
                }
            }
            $this->Flash->error(__($error));
        }
    }

    // #eggodev -> función que gestiona el logout de los usuarios
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
