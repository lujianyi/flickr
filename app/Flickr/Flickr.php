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

    public static $STATUS_OK = 1;
    public static $STATUS_INPUT_ERROR = -1;
    public static $STATUS_CONNECTION_ERROR = -2;
    public static $STATUS_DATA_STRUCTURE_ERROR = -3;
    public static $STATUS_DATA_ERROR = -4;


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
            return ['code' => self::$STATUS_INPUT_ERROR, 'message' => 'Text is empty.'];
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
            return ['code' => self::$STATUS_CONNECTION_ERROR, 'message' => $e->getMessage()];
        }

        try{
            $resObj = json_decode($res);
        }
        catch (Exception $e) {
            return ['code' => self::$STATUS_DATA_STRUCTURE_ERROR, 'message' => $e->getMessage()];
        }

        if(!str_is('ok', $resObj->stat)){
            return ['code' => self::$STATUS_DATA_ERROR, 'message' => 'Data error'];
        }

        return ['code' => self::$STATUS_OK, 'photos' => $resObj->photos];
    }

    /**
     * Get photo info
     *
     * @param $id
     * @return array
     */
    public function getPhotoInfo($id){
        if(empty($id)){
            return ['code' => self::$STATUS_INPUT_ERROR, 'message' => 'Id is empty.'];
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
            return ['code' => self::$STATUS_CONNECTION_ERROR, 'message' => $e->getMessage()];
        }

        try{
            $resObj = json_decode($res);
        }
        catch (Exception $e) {
            return ['code' => self::$STATUS_DATA_STRUCTURE_ERROR, 'message' => $e->getMessage()];
        }

        if(empty($resObj->photo)){
            return ['code' => self::$STATUS_DATA_ERROR, 'message' => 'Data error'];
        }

        return ['code' => self::$STATUS_OK, 'photo' => $resObj->photo];
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
            return ['code' => self::$STATUS_INPUT_ERROR, 'message' => 'Id is empty.'];
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
            return ['code' => self::$STATUS_CONNECTION_ERROR, 'message' => $e->getMessage()];
        }

        try{
            $resObj = json_decode($res);
        }
        catch (Exception $e) {
            return ['code' => self::$STATUS_DATA_STRUCTURE_ERROR, 'message' => $e->getMessage()];
        }

        if(!str_is('ok', $resObj->stat)){
            return ['code' => self::$STATUS_DATA_ERROR, 'message' => 'Data error'];
        }

        return ['code' => self::$STATUS_OK, 'photo' => last(
                array_filter($resObj->sizes->size, function($value) {
                    return str_is('photo', $value->media);
            })
        )];
    }

    /**
     * Set json format
     *
     * @return string
     */
    private function jsonFormat(){
        return 'format=json&nojsoncallback=1';
    }

    /**
     * set page size
     *
     * @return string
     */
    private function pageSize(){
        return '&per_page=' . $this->pageSize;
    }

}