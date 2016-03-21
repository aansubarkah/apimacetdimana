<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Accesses Controller
 *
 * @property \App\Model\Table\AccessesTable $Accesses
 */
class AccessesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Browsers', 'Cpus', 'Devices', 'Engines', 'Systems']
        ];
        $this->set('accesses', $this->paginate($this->Accesses));
        $this->set('_serialize', ['accesses']);
    }

    /**
     * View method
     *
     * @param string|null $id Access id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $access = $this->Accesses->get($id, [
            'contain' => ['Browsers', 'Cpus', 'Devices', 'Engines', 'Systems']
        ]);
        $this->set('access', $access);
        $this->set('_serialize', ['access']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        //$access = $this->Accesses->newEntity();
        if ($this->request->is('post')) {
            $dataToSave = [];
            $dataToSave['ip'] = $this->request->clientIp();
            $dataToSave['browser_id'] = $this->saveBrowser(
                $this->request->data['access']['browserName'],
                $this->request->data['access']['browserVersion']
            );

            $dataToSave['cpu_id'] = $this->saveCpu(
                $this->request->data['access']['cpuArchitecture']
            );

            $dataToSave['device_id'] = $this->saveDevice(
                $this->request->data['access']['deviceModel'],
                $this->request->data['access']['deviceType'],
                $this->request->data['access']['deviceVendor']
            );

            $dataToSave['engine_id'] = $this->saveEngine(
                $this->request->data['access']['engineName'],
                $this->request->data['access']['engineVersion']
            );

            $dataToSave['system_id'] = $this->saveSystem(
                $this->request->data['access']['systemName'],
                $this->request->data['access']['systemVersion']
            );

            $dataToSave['active'] = 1;

            $access = $this->Accesses->newEntity($dataToSave);
            $this->Accesses->save($access);
            }
        $this->set(compact('access'));
        $this->set('_serialize', ['access']);
    }

    private function saveBrowser($name = null, $version = null)
    {
        $name = trim($name);
        $version = trim($version);

        $name == null ? $name = 'Not Detected' : $name = $name;
        $version == null ? $version = 'Not Detected' : $version = $version;
        $browser_id = 1;

        $options = [
            'conditions' => [
                'LOWER(name) LIKE' => '%' . strtolower($name) . '%',
                'LOWER(version) LIKE' => '%' . strtolower($version) . '%'
            ],
            'limit' => 1
        ];
        // first check if browser exist on table

        $browser = $this->Accesses->Browsers->find('all', $options);
        $browserCount = $browser->count();

        if ($browserCount < 1) {
            $dataToSave = [
                'name' => $name,
                'version' => $version,
                'active' => 1
            ];

            $browser = $this->Accesses->Browsers->newEntity($dataToSave);
            $this->Accesses->Browsers->save($browser);

            $browser_id = $browser->id;
        } else {
            $browser = $this->Accesses->Browsers->find('all', $options)->toArray();
            $browser_id = $browser[0]['id'];
        }

        return $browser_id;
    }

    private function saveCpu($name = null)
    {
        $name = trim($name);
        $name == null ? $name = 'Not Detected' : $name = $name;

        $data_id = 1;

        $options = [
            'conditions' => [
                'LOWER(architecture) LIKE' => '%' . strtolower($name) . '%'
            ],
            'limit' => 1
        ];
        // first check if cpu exist on table

        $data = $this->Accesses->Cpus->find('all', $options);
        $dataCount = $data->count();

        if ($dataCount < 1) {
            $dataToSave = [
                'architecture' => $name,
                'active' => 1
            ];

            $datum = $this->Accesses->Cpus->newEntity($dataToSave);
            $this->Accesses->Cpus->save($datum);

            $data_id = $datum->id;
        } else {
            $data = $this->Accesses->Cpus->find('all', $options)->toArray();
            $data_id = $data[0]['id'];
        }

        return $data_id;
    }

    private function saveDevice($model = null, $type = null, $vendor = null)
    {
        $model = trim($model);
        $type = trim($type);
        $vendor = trim($vendor);

        $model == null ? $model = 'Not Detected' : $model = $model;
        $type == null ? $type = 'Not Detected' : $type = $type;
        $vendor == null ? $vendor = 'Not Detected' : $vendor = $vendor;

        $data_id = 1;

        $options = [
            'conditions' => [
                'LOWER(model) LIKE' => '%' . strtolower($model) . '%',
                'LOWER(type) LIKE' => '%' . strtolower($type) . '%',
                'LOWER(vendor) LIKE' => '%' . strtolower($vendor) . '%'
            ],
            'limit' => 1
        ];
        // first check if cpu exist on table

        $data = $this->Accesses->Devices->find('all', $options);
        $dataCount = $data->count();

        if ($dataCount < 1) {
            $dataToSave = [
                'model' => $model,
                'type' => $type,
                'vendor' => $vendor,
                'active' => 1
            ];

            $datum = $this->Accesses->Devices->newEntity($dataToSave);
            $this->Accesses->Devices->save($datum);

            $data_id = $datum->id;
        } else {
            $data = $this->Accesses->Devices->find('all', $options)->toArray();
            $data_id = $data[0]['id'];
        }

        return $data_id;
    }

    private function saveEngine($name = null, $version = null)
    {
        $name = trim($name);
        $version = trim($version);

        $name == null ? $name = 'Not Detected' : $name = $name;
        $version == null ? $version = 'Not Detected' : $version = $version;
        $data_id = 1;

        $options = [
            'conditions' => [
                'LOWER(name) LIKE' => '%' . strtolower($name) . '%',
                'LOWER(version) LIKE' => '%' . strtolower($version) . '%'
            ],
            'limit' => 1
        ];
        // first check if browser exist on table

        $data = $this->Accesses->Engines->find('all', $options);
        $dataCount = $data->count();

        if ($dataCount < 1) {
            $dataToSave = [
                'name' => $name,
                'version' => $version,
                'active' => 1
            ];

            $datum = $this->Accesses->Engines->newEntity($dataToSave);
            $this->Accesses->Engines->save($datum);

            $data_id = $datum->id;
        } else {
            $data = $this->Accesses->Engines->find('all', $options)->toArray();
            $data_id = $data[0]['id'];
        }

        return $data_id;
    }

    private function saveSystem($name = null, $version = null)
    {
        $name = trim($name);
        $version = trim($version);

        $name == null ? $name = 'Not Detected' : $name = $name;
        $version == null ? $version = 'Not Detected' : $version = $version;

        $data_id = 1;

        $options = [
            'conditions' => [
                'LOWER(name) LIKE' => '%' . strtolower($name) . '%',
                'LOWER(version) LIKE' => '%' . strtolower($version) . '%'
            ],
            'limit' => 1
        ];
        // first check if browser exist on table

        $data = $this->Accesses->Systems->find('all', $options);
        $dataCount = $data->count();

        if ($dataCount < 1) {
            $dataToSave = [
                'name' => $name,
                'version' => $version,
                'active' => 1
            ];

            $datum = $this->Accesses->Systems->newEntity($dataToSave);
            $this->Accesses->Systems->save($datum);

            $data_id = $datum->id;
        } else {
            $data = $this->Accesses->Systems->find('all', $options)->toArray();
            $data_id = $data[0]['id'];
        }

        return $data_id;
    }

    /**
     * Edit method
     *
     * @param string|null $id Access id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $access = $this->Accesses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $access = $this->Accesses->patchEntity($access, $this->request->data);
            if ($this->Accesses->save($access)) {
                $this->Flash->success(__('The access has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The access could not be saved. Please, try again.'));
            }
        }
        $browsers = $this->Accesses->Browsers->find('list', ['limit' => 200]);
        $cpus = $this->Accesses->Cpus->find('list', ['limit' => 200]);
        $devices = $this->Accesses->Devices->find('list', ['limit' => 200]);
        $engines = $this->Accesses->Engines->find('list', ['limit' => 200]);
        $systems = $this->Accesses->Systems->find('list', ['limit' => 200]);
        $this->set(compact('access', 'browsers', 'cpus', 'devices', 'engines', 'systems'));
        $this->set('_serialize', ['access']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Access id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $access = $this->Accesses->get($id);
        if ($this->Accesses->delete($access)) {
            $this->Flash->success(__('The access has been deleted.'));
    } else {
        $this->Flash->error(__('The access could not be deleted. Please, try again.'));
    }
    return $this->redirect(['action' => 'index']);
    }
    }
