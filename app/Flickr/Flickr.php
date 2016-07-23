<?php namespace App\Flickr;


use Exception;

class Flickr
{

    protected $apiKey = null; // when parsing url, the api key is named as consumer key
    protected $apiSecret = null;
    protected $apiUrl = null;

    protected $methodSearch = 'flickr.photos.search';
    protected $methodInfo = 'flickr.photos.getInfo';
    protected $methodSize = 'flickr.photos.getSizes';

    protected $pageSize = 20;

    /**
     * Flickr constructor.
     */
    public function __construct()
    {
        $this->apiKey = env('FLICKR_API_KEY');
        $this->apiSecret = env('FLICKR_API_SECRET');
        $this->apiUrl = env('FLICKR_API_URL');
    }

    /**
     * Get photo list by searching text
     *
     * @param null $text
     * @param int $page
     * @return array
     */
    public function getPhotoList($text = null, $page = 1)
    {
        if(empty($text)){
            return ['code' => -1, 'message' => 'Text is empty.'];
        }

        $requestUrl = $this->apiUrl;
        $requestUrl .= '?method=' . $this->methodSearch;
        $requestUrl .= '&api_key=' . $this->apiKey;
        $requestUrl .= '&text=' . $text;
        $requestUrl .= '&page=' . $page;
        $requestUrl .= '&' . $this->jsonFormat();
        $requestUrl .= '&' . $this->pageSize();

        try{
            $res = file_get_contents($requestUrl);
        }
        catch (Exception $e) {
            return ['code' => -2, 'message' => $e->getMessage()];
        }

        try{
            $resObj = json_decode($res);
        }
        catch (Exception $e) {
            return ['code' => -3, 'message' => $e->getMessage()];
        }

        if(!str_is('ok', $resObj->stat)){
            return ['code' => -4, 'message' => 'Data error'];
        }

        return ['code' => 1, 'photos' => $resObj->photos];
    }

    /**
     * Get photo info
     *
     * @param $id
     * @return array
     */
    public function getPhotoInfo($id){
        if(empty($id)){
            return ['code' => -1, 'message' => 'Id is empty.'];
        }

        $requestUrl = $this->apiUrl;
        $requestUrl .= '?method=' . $this->methodInfo;
        $requestUrl .= '&api_key=' . $this->apiKey;
        $requestUrl .= '&photo_id=' . $id;
        $requestUrl .= '&' . $this->jsonFormat();

        try{
            $res = file_get_contents($requestUrl);
        }
        catch (Exception $e) {
            return ['code' => -2, 'message' => $e->getMessage()];
        }

        try{
            $resObj = json_decode($res);
        }
        catch (Exception $e) {
            return ['code' => -3, 'message' => $e->getMessage()];
        }

        if(empty($resObj->photo)){
            return ['code' => -4, 'message' => 'Data error'];
        }

        return ['code' => 1, 'photo' => $resObj->photo];
    }

    /**
     * Get photo url to display on the page
     *
     * @param $id
     * @return array
     */
    public function getPhoto($id)
    {
        if (empty($id)) {
            return ['code' => -1, 'message' => 'Id is empty.'];
        }

        $requestUrl = $this->apiUrl;
        $requestUrl .= '?method=' . $this->methodSize;
        $requestUrl .= '&api_key=' . $this->apiKey;
        $requestUrl .= '&photo_id=' . $id;
        $requestUrl .= '&' . $this->jsonFormat();

        try{
            $res = file_get_contents($requestUrl);
        }
        catch (Exception $e) {
            return ['code' => -2, 'message' => $e->getMessage()];
        }

        try{
            $resObj = json_decode($res);
        }
        catch (Exception $e) {
            return ['code' => -3, 'message' => $e->getMessage()];
        }

        if(!str_is('ok', $resObj->stat)){
            return ['code' => -4, 'message' => 'Data error'];
        }

        return ['code' => 1, 'photo' => array_pop($resObj->sizes->size)]; // get the largest photo size
    }

    private function jsonFormat(){
        return 'format=json&nojsoncallback=1';
    }

    private function pageSize(){
        return '&per_page=' . $this->pageSize;
    }

}