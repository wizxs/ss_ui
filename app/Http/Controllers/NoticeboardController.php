<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Repos\Notice\NoticeRepository;
use App\Http\Requests\PinNoticeRequest;



class NoticeboardController extends Controller
{
    /**
     * @var NoticeRepository
     */
    private $noticeRepository;

    /**
     * Initialize variables for the controller.
     *
     * @param NoticeRepository $noticeRepository
     */
    function __construct(NoticeRepository $noticeRepository)
    {
        $this->noticeRepository = $noticeRepository;
    }

    /**
     * Display a listing of the user's notices.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "NoticeBoard";

        $notices = $this->noticeRepository->getUserNotices(\Auth::user());

        return view('ss.noticeboards.index', compact('title', 'notices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PinNoticeRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PinNoticeRequest $request)
    {
        $this->noticeRepository->storeNotices($request, \Auth::user());

        Toastr::success('Notice pinned successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $noticeId
     * @return \Illuminate\Http\Response
     */
    public function destroy($noticeId)
    {
        if(!$this->noticeRepository->deleteNotice($noticeId))
        {
            Toastr::error("You do not own the notice you are trying to delete");
            return redirect()->back();
        }

        Toastr::success('Pin successfully deleted');
        return redirect()->back();
    }
}
