<?php namespace App\Http\Controllers\Auth;
use Hash;
use Auth; 
use Session;
use Socialize;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

 
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
 
class AuthController extends Controller {
 
    /**
     * the model instance
     * @var User
     */
    protected $user; 
    /**
     * The Guard implementation.
     *
     * @var Authenticator
     */
    protected $auth;

 
    /**
     * Create a new authentication controller instance.
     *
     * @param  Authenticator  $auth
     * @return void
     */	 
	 
    public function __construct(Guard $auth, User $user)
    {
        $this->user = $user; 
        $this->auth = $auth;
 
        $this->middleware('guest', ['except' => ['getLogout']]); 
    }
	
	
    /**
     * Show the application registration form.
     *
     * @return Response
     */
    public function getRegister()
    {
        return view('auth.register');
    }
 
    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterRequest  $request
     * @return Response
     */
    public function postRegister(RegisterRequest $request)
    {
        //code for registering a user goes here.
		$this->user->username = $request->username;
		$password = $request->input('password');
		$this->user->password = Hash::make($password);	
		//$this->user->password = $request->password;
		//User::up($username,$password);	
		$this->user->save();
        $this->auth->login($this->user); 
			
        return redirect('/login');
    }
 
    /**
     * Show the application login form.
     *
     * @return Response
     */
    public function getLogin()
    {
        return view('auth.login');
    }
 
    /**
     * Handle a login request to the application.
     *
     * @param  LoginRequest  $request
     * @return Response
     */
    public function postLogin(LoginRequest $request)
    {	
		$username = $request->input('username');
		$password = $request->input('password');		
        if (Auth::attempt(['username' => $username, 'password' => $password]))
        {
			$intendedUrl = Session::get('url.intended');
			Session::forget('url.intended');
			return redirect($intendedUrl);
            //return redirect()->intended('/user');
        }
 
        return redirect('/login')->withErrors([
            'username' => 'Sisestatud kasutajanimi või parool on vale.',
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @return Response
     */
    public function getLogout()
    {
        $this->auth->logout();
		
        $intendedUrl = Session::get('url.intended');
		Session::forget('url.intended');
		return redirect($intendedUrl);
    }
	
	public function facebookauth()
    {
        return Socialize::with('facebook')->redirect();
    }
	
	public function facebooklogin()
    {
        $user2 = Socialize::with('facebook')->user();
		$username = $user2->getEmail();
		
		if (Auth::attempt(['username' => $username, 'password' => "parool"]))
        {
			
            $intendedUrl = Session::get('url.intended');
			Session::forget('url.intended');
			return redirect($intendedUrl);
        }
		else
		{	
			$password = Hash::make("parool");
			$this->user->username = $username;
			$this->user->password = $password;			
			$this->user->save();
			$this->auth->login($this->user); 
			
			$intendedUrl = Session::get('url.intended');
			Session::forget('url.intended');
			return redirect($intendedUrl);
		}		
    }
	
}