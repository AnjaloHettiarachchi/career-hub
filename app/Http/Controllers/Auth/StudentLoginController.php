<?php

namespace App\Http\Controllers\auth;

use Adldap\Auth\BindException;
use Adldap\Auth\PasswordRequiredException;
use Adldap\Auth\UsernameRequiredException;
use Adldap\Laravel\Facades\Adldap;
use App\Student;
use App\StudentUser;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentLoginController extends Controller
{

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:student')->except('logout');
    }

    public function username()
    {
        return config('ldap_auth.identifiers.database.username_column');
    }

    public function showStudentLogin()
    {
        return view('students.login')->with('title', 'Student › Login | ' . env('APP_NAME'));
    }

    protected function attemptLogin(Request $request)
    {
        $errors = [];

        $this->validate($request, [
            $this->username() => 'required|string|regex:/^\w+$/',
            'password' => 'required|string'
        ], [], [
            $this->username() => 'Username',
            'password' => 'Password'
        ]);

        $credentials = $request->only($this->username(), 'password');
        $username = $credentials[$this->username()];
        $password = $credentials['password'];

        $user_format = env('LDAP_USER_FORMAT', 'cn=%s,'.env('LDAP_BASE_DN', ''));
        $user_dn = sprintf($user_format, $username);

        try {
            if (Adldap::auth()->attempt($user_dn, $password, $bindAsUser = true)) {
                // the user exists in the LDAP server, with the provided password
                $user = StudentUser::where($this->username(), $username)->first();

                if (!$user) {
                    // the user doesn't exist in the local database, so we have to create one
                    $stu_user = new StudentUser();
                    $stu_user->stu_user_name = $username;
                    $stu_user->save();
                    Auth::guard('student')->loginUsingId($stu_user->stu_user_id, true);
                    return redirect()->route('students.showCreate');
                } else {
                    // the user exists in the local database
                    Auth::guard('student')->login($user, true);
                    $stu = Student::where('stu_user_id', $user->stu_user_id)->first();
                    if (!$stu) {
                        return redirect()->route('students.showCreate');
                    } else {
                        return redirect()->route('students.home', $user->stu_user_id);
                    }
                }

            } else {
                return redirect()->back()
                    ->with('error', 'Invalid Username or Password.')
                    ->withInput();
            }
        } catch (BindException $e) {
            array_push($errors, $e->getMessage());
        } catch (PasswordRequiredException $e) {
            array_push($errors, $e->getMessage());
        } catch (UsernameRequiredException $e) {
            array_push($errors, $e->getMessage());
        }

        // the user doesn't exist in the LDAP server or the password is wrong
        return redirect()->back()
            ->with('errors', $errors)
            ->withInput();
    }

    public function logout()
    {
        Auth::guard('student')->logout();
        return redirect()->route('site.index');
    }

}
