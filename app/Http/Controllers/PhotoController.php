<?php namespace App\Http\Controllers;

use App\Flickr\Flickr;
use Illuminate\Http\Request;

use App\Http\Requests;

class PhotoController extends Controller
{
    private $flickr = null;

    /**
     * PhotoController constructor.
     * @param Flickr $flickr
     */
    public function __construct(Flickr $flickr)
    {
        $this->flickr = $flickr;
    }

    /**
     * Home Page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('photo.index');
    }

    /**
     * Photo list of search result
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $this->validate($request,
            ['text' => 'required'],
            ['required' => 'The field is required. Please input proper value.']
        );

        $search = $request->get('text');
        $page = $request->get('page');
        $data = $this->flickr->getPhotoList($search, $page);
        $photoList = $data['code'] == Flickr::$STATUS_OK ? $data['photos'] : [];
        $url = route('search') . '?text=' . $search;
        return view('photo.list', compact('photoList', 'url'));
    }

    /**
     * Show photo
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $data = $this->flickr->getPhotoInfo($id);
        $photoInfo = $data['code'] == Flickr::$STATUS_OK ? $data['photo'] : [];
        $data = $this->flickr->getPhoto($id);
        $photo = $data['code'] == Flickr::$STATUS_OK ? $data['photo'] : [];
        return view('photo.view', compact('photoInfo', 'photo'));
    }

}
