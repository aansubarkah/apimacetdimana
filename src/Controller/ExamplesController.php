<?php
namespace App\Controller;

use App\Controller\AppController;
use TwitterAPIExchange;

/**
 * Examples Controller
 *
 * @property \App\Model\Table\ExamplesTable $Examples
 */
class ExamplesController extends AppController
{
    public $settingsTwitter = [
        'oauth_access_token' => '3555146480-IyxJFfUPB3wbWCduVEP8rQ3siBgOvOoe8PzWZSC',
        'oauth_access_token_secret' => 'aGebfzV4br0N3eus5Yu8JAFNl23ItqKB6yifblNO4EJn0',
        'consumer_key' => '0pKhijN1hOLjR0x5OSWK1mepL',
        'consumer_secret' => 'JKK7SFgIsUPhWeJT7i20rrfZoUxRUJb76gFkP5xRz9ssMBqpzV'
    ];

    private $baseTwitterUrl = 'https://api.twitter.com/1.1/';

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $q = 'macet';
        $dataStream = $this->getLocation($q);
        $dataToDisplay = [];
        if ($dataStream['search_metadata']['count'] > 0) {
            $id = 1;
            foreach ($dataStream['statuses'] as $data) {
                if ($data['geo'] !== null) {
                    $dataToDisplay[] = [
                        'id' => $id,
                        'twitTime' => date("Y-m-d H:i:s", strtotime($data['created_at'])),
                        'twitPlaceName' => $data['place']['name'],
                        'info' => $this->getThreeString((string)$data['text'], $q),
                        'lat' => $data['geo']['coordinates'][0],
                        'lng' => $data['geo']['coordinates'][1]
                    ];
                    $id++;
                }
            }
        }

        $q='padat';
        $dataStream = $this->getLocation($q);
        if ($dataStream['search_metadata']['count'] > 0) {
            $id = 1;
            foreach ($dataStream['statuses'] as $data) {
                if ($data['geo'] !== null) {
                    $dataToDisplay[] = [
                        'id' => $id,
                        'twitTime' => date("Y-m-d H:i:s", strtotime($data['created_at'])),
                        'twitPlaceName' => $data['place']['name'],
                        'info' => $this->getThreeString((string)$data['text'], $q),
                        'lat' => $data['geo']['coordinates'][0],
                        'lng' => $data['geo']['coordinates'][1]
                    ];
                    $id++;
                }
            }
        }

        $meta = [
            'total' => count($dataToDisplay)
        ];

        $this->set([
            'examples' => $dataToDisplay,
            'meta' => $meta,
            '_serialize' => ['examples', 'meta']
        ]);
    }

    public function location()
    {
        $q = 'macet';
        $dataStream = $this->getLocation($q);
        //$dataToDisplay = [];
        if ($dataStream['search_metadata']['count'] > 0) {
            $meta = [
                'total' => $dataStream['search_metadata']['count']
            ];

            $this->set([
                'examples' => $dataStream,
                'meta' => $meta,
                '_serialize' => ['examples', 'meta']
            ]);
        }
    }

    private function getThreeString($text, $keyword)
    {
        $text = preg_replace("/[^A-Za-z0-9]/", ' ', $text);
        $text = strtolower($text);
        $textArr = explode(" ", $text);
        $countTextArr = count($textArr);
        $keywordPosition = array_search($keyword, $textArr);
        $textToReturn = $textArr[$keywordPosition];

        if (($keywordPosition - 1) >= 0) {
            $textToReturn = $textArr[$keywordPosition - 1] . ' ' . $textToReturn;
        }
        if (($keywordPosition + 1) < $countTextArr) {
            $textToReturn = $textToReturn . ' ' . $textArr[$keywordPosition + 1];
        }

        return trim($textToReturn);
    }

    private function getLocation($q = null)
    {
        if ($q === null) {
            $q = 'macet';
        }

        /*
         *
        Jalan Jenderal Ahmad Yani
        Magelang Tengah, Kota Magelang, Jawa Tengah 56117
        -7.473215, 110.218126
         * */
        /*
   *
   Jalan Medan Merdeka Utara No.9-13
   Gambir, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10110
   -6.171476, 106.826937
   * */
        //$geocode = '-7.473215,110.218126,1000km';
        $geocode = '-6.171305,106.827967,80km';
        $Twitter = new TwitterAPIExchange($this->settingsTwitter);

        $url = $this->baseTwitterUrl . 'search/tweets.json';
        $getfield = '?q=' . $q;
        $getfield = $getfield . '&since_id=1';
        $count = 100;

        $getfield = $getfield . '&geocode=' . $geocode;
        $getfield = $getfield . '&q=' . $q;
        $getfield = $getfield . '&count=' . $count;
        $getfield = $getfield . '&result_type=recent';
        $requestMethod = 'GET';

        $data = $Twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();

        return json_decode($data, true);
    }
}
