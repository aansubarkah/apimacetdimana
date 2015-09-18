<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Markerviews Controller
 *
 * @property \App\Model\Table\MarkerviewsTable $Markerviews
 */
class MarkerviewsController extends AppController
{

    public $limit = 25;

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $limit = $this->limit;
        if (isset($this->request->query['limit'])) {
            if (is_numeric($this->request->query['limit'])) {
                $limit = $this->request->query['limit'];
            }
        }

        $page = 1;
        $offset = 0;
        if (isset($this->request->query['page'])) {
            if (is_numeric($this->request->query['page'])) {
                $page = (int)$this->request->query['page'];
                $offset = ($page - 1) * $limit;
            }
        }

        $lastMinutes = 30;//default is past 30 minutes
        if (isset($this->request->query['lastminutes'])) {
            if (is_numeric($this->request->query['lastminutes'])) {
                $lastMinutes = $this->request->query['lastminutes'];
            }
        }
        $lastMinutesString = '-' . $lastMinutes . ' minutes';

        $conditions = [
            'Markerviews.active' => true,
            'OR' => [
                'Markerviews.created >=' => date('Y-m-d H:i:s', strtotime($lastMinutesString)),
                'AND' => [
                    'Markerviews.pinned' => true,
                    'Markerviews.cleared' => false,
                ]
            ]
        ];

        $markerviews = $this->Markerviews->find()
            ->where($conditions)
            ->order(['Markerviews.twitTime' => 'ASC', 'Markerviews.created' => 'ASC'])
            //->limit($limit)->page($page)->offset($offset)
            ->toArray();
        $allMarkerviews = $this->Markerviews->find()->where($conditions);
        $total = $allMarkerviews->count();

        $meta = [
            'total' => $total
        ];
        $this->set([
            'markerviews' => $markerviews,
            'meta' => $meta,
            '_serialize' => ['markerviews', 'meta']
        ]);
    }

    public function checkExistence($name = null, $limit = 25)
    {
        $data = [
            [
                'id' => 0,
                'name' => '',
                'active' => 0
            ]
        ];

        $fetchDataOptions = [
            'order' => ['Markerviews.name' => 'ASC'],
            'limit' => $limit
        ];

        $query = trim(strtolower($name));

        if (!empty($query)) {
            $fetchDataOptions['conditions']['LOWER(Markerviews.name) LIKE'] = '%' . $query . '%';
        }

        $markerviewview = $this->Markerviews->find('all', $fetchDataOptions);

        if ($markerviewview->count() > 0) {
            $data = $markerviewview;
        }

        $this->set([
            'markerviewview' => $data,
            '_serialize' => ['markerviewview']
        ]);
    }
}
