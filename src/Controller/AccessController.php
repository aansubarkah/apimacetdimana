<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Access Controller
 *
 * @property \App\Model\Table\AccessTable $Access
 */
class AccessController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('access', $this->paginate($this->Access));
        $this->set('_serialize', ['access']);
    }

    /**
     * View method
     *
     * @param string|null $id Acces id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $acces = $this->Access->get($id, [
            'contain' => []
        ]);
        $this->set('acces', $acces);
        $this->set('_serialize', ['acces']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $acces = $this->Access->newEntity();
        if ($this->request->is('post')) {
            $acces = $this->Access->patchEntity($acces, $this->request->data);
            if ($this->Access->save($acces)) {
                $this->Flash->success(__('The acces has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The acces could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('acces'));
        $this->set('_serialize', ['acces']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Acces id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $acces = $this->Access->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $acces = $this->Access->patchEntity($acces, $this->request->data);
            if ($this->Access->save($acces)) {
                $this->Flash->success(__('The acces has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The acces could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('acces'));
        $this->set('_serialize', ['acces']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Acces id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $acces = $this->Access->get($id);
        if ($this->Access->delete($acces)) {
            $this->Flash->success(__('The acces has been deleted.'));
        } else {
            $this->Flash->error(__('The acces could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
