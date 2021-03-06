<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Repos\File\FileRepository;
use App\Repos\Group\GroupRepository;
use App\Traits\File\ShareFile;
use App\Traits\File\StoreFile;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Kamaln7\Toastr\Facades\Toastr;

class FileController extends Controller
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;
    /**
     * @var FileRepository
     */
    private $fileRepository;

    /**
     * Initialize the variables for the controller.
     *
     * @param GroupRepository $groupRepository
     * @param FileRepository $fileRepository
     */
    function __construct(GroupRepository $groupRepository,FileRepository $fileRepository)
    {

        $this->groupRepository = $groupRepository;
        $this->fileRepository = $fileRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function backpack()
    {

        $title = 'BackPack';
        $files = $this->fileRepository
            ->getBackpackFilesForUser(Auth::user());
        $topics = $this->fileRepository
            ->getBackpackTopicsForUser(Auth::user());

        return view('ss.backpack.index', compact('title', 'files', 'topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $groupUsername
     * @return \Illuminate\Http\Response
     */
    public function groupFiles($groupUsername)
    {

        $group = $this->groupRepository
            ->findGroupWithUsername($groupUsername);

        $title = $group->name . "'s files";
        $topics = $this->fileRepository
            ->getGroupTopicsForGroup($group);

        $files = $this->fileRepository
            ->groupFilesForGroup($group);

        return view('ss.groups.files', compact('title', 'files', 'topics', 'group'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UploadFileRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadFileRequest $request)
    {
        $this->fileRepository->store($request, \Auth::user());
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $fileId
     * @return \Illuminate\Http\Response
     */
    public function destroy($fileId)
    {
        $file = $this->fileRepository->findFileById($fileId);

        if(!$this->fileRepository->deleteFile($file))
        {
            Toastr::error("You do not own the file you are deleting");
            return redirect()->back();
        }

        Toastr::success('You have successfully deleted the file');
        return redirect()->back();

    }
}
