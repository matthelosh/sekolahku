<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthUserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->middleware(['auth', 'verified']);

Route::group(['prefix' => 'auth'], function(){
    Route::get('login', [AuthUserController::class, 'login'])->name('login');
    Route::post('login', [AuthUserController::class, 'authenticate'])->name('authenticate');
    Route::get('register', [AuthUserController::class, 'register'])->name('register');
    Route::post('register', [AuthUserController::class, 'regUser'])->name('reg-user');

    Route::group(['prefix' => 'email'], function() {
        Route::get('/verify', function () {
            return view('auth.verify-email');
        })->middleware('auth')->name('verification.notice');
    
        Route::get('/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
        
            return redirect('/');
        })->middleware(['auth', 'signed'])->name('verification.verify');
    
        Route::post('/verification-notification', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();
        
            return back()->with('message', 'Verification link sent!');
        })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    });

    Route::group(['prefix' => 'password'], function() {
        Route::get('/forgot', function () {
            return view('auth.forgot-password');
        })->middleware('guest')->name('forgot-password');
    
        Route::post('/forgot', [AuthUserController::class, 'forgotPassword'])->middleware('guest')->name('password.email');
    
        Route::get('/reset/{token}', function ($token) {
            return view('auth.reset-password', ['token' => $token]);
        })->name('password.reset');
    
        Route::post('/reset', [AuthUserController::class, 'resetPassword'])->middleware('guest')->name('reset-password');
    
    }); 
});

Route::post('auth-google', function(Request $request){
    $authCode = $request->authCode;
    // dd($authCode);
    $client = new Google_Client();
    $client->setAuthConfig(public_path('/credentials.json'));
    $client->setAccessType('offline');
    $tokenPath = public_path('/token.json');
    
    
    if (!file_exists(dirname($tokenPath))) {
        mkdir(dirname($tokenPath), 0700, true);
    }
    file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
    $client->setAccessToken($accessToken);

    $client->setScopes(Google_Service_Classroom::CLASSROOM_COURSES);
    $service = new Google_Service_Classroom($client);
    $courseId = '160136065366';
    $student = new Google_Service_Classroom_Student(array('email' => 'abdul.hafizh.1819@sdn1-bedalisodo.sch.id'));

    $student = $service->courses_students->create($courseId, $student);
    dd($student);
});

Route::get('/tes', function(Request $request){
    $client = new Google_Client();
    $client->setScopes([Google_Service_Classroom::CLASSROOM_ROSTERS, Google_Service_Classroom::CLASSROOM_COURSES]);
    $client->setAuthConfig(public_path('/credentials.json'));
    $client->setAccessType('offline');
    $tokenPath = public_path('/token.json');
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
        // return 'Halo';
        $courseId = '160136065366';
        $service = new Google_Service_Classroom($client);
        $student = new Google_Service_Classroom_Student(array(
            'userId' => 'abdul.hafizh.1819@sdn1-bedalisodo.sch.id'
          ));

        try {
            $student = $service->courses_students->create($courseId, $student);
            printf("User '%s' was enrolled  as a student in the course with ID '%s'.\n",
                $student->profile->name->fullName, $courseId);
        } catch (Google_Service_Exception $e) {
            if ($e->getCode() == 409) {
            print "You are already a member of this course.\n";
            } else {
            throw $e;
            }
        }
    } else {
        $authUrl = $client->createAuthUrl();
        return 'Open This URL to Authenticate <br> <a href="'.$authUrl.'" target="blank">Auth on Google</a><br> <form method="post" action="/auth-google"><input type="hidden" name="_token" value="'.csrf_token().'" /><label for="authCode">Masukkan kode dari Google</label><input type="text" name="authCode"><button type="submit">Kirim</button></form>';
    }
    
    // // $enrollmentCode = 'abcdef';
    // $student = new Google_Service_Classroom_Student(array(
    // 'userId' => 'abdul.hafizh.1819@sdn1-bedalisodo.sch.id'
    // ));
    // $tokenPath = public_path('/token.json');
    // if (file_exists($tokenPath)) {
    //     $accessToken = json_decode(file_get_contents($tokenPath), true);
    //     $client->setAccessToken($accessToken);
    // }
    
    // $student = new Google_service_Classroom_Student(array('email' => 'abdul.hafizh.1819@sdn1-bedalisodo.sch.id'));
    // try {
    //     $student = $service->courses_students->create($courseId, $student);
    //     printf("User '%s' was enrolled  as a student in the course with ID '%s'.\n",
    //         $student->profile->name->fullName, $courseId);
    //   } catch (Google_Service_Exception $e) {
    //     if ($e->getCode() == 409) {
    //       print "You are already a member of this course.\n";
    //     } else {
    //       throw $e;
    //     }
    //   }
    
    // $student = $service->courses_students->create($courseId, $student);
    // dd($client);
});
Route::get('/oauth2', function(Request $request){
    $tokenPath = public_path('/token.json');
    $client = new Google_Client();
    $client->setAuthConfig(public_path('/credentials.json'));
    $accessToken = $client->fetchAccessTokenWithAuthCode($request->code);
    $client->setAccessToken($accessToken);
    if (array_key_exists('error', $accessToken)) {
        throw new Exception(join(',', $accessToken));
    }

    if (!file_exists(dirname($tokenPath))) {
        mkdir(dirname($tokenPath), 0700, true);
    }
    $simpan = file_put_contents($tokenPath, json_encode($client->getAccessToken()));

    return redirect('/tes');
});














Route::get('logout', [AuthUserController::class, 'logout'])->name('logout');