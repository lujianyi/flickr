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

    public function index()
    {
        return view('photo.index');
    }

    public function search(Request $request)
    {
        $this->validate($request,
            ['text' => 'required'],
            ['required' => 'The field is required. Please input proper value.']
        );

        $search = $request->get('text');
        $page = $request->get('page');
        $res = $this->flickr->getPhotoList($search, $page);
        $photoList = $res['code'] == Flickr::$STATUS_OK ? $res['photos'] : [];
        $url = route('search') . '?text=' . $search;
        return view('photo.list', compact('photoList', 'url'));
    }

}
