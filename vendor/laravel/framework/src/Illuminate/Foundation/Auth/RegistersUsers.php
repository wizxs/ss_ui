<?php namespace Illuminate\Foundation\Auth;

use App\Course;
use App\Institution;
use App\Traits\UserMailerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kamaln7\Toastr\Facades\Toastr;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        $courses = Course::all();
        $institutions = Institution::all();
        return view('ss.auth.signup', compact('courses', 'institutions'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        Auth::login($this->create($request->all()));

        $this->assignGroupTo(\Auth::user());

        $this->sendConfirmationMailTo(\Auth::user(), \Auth::user()->code);

        return response('User successfully registered.',200,[]);
    }
}
