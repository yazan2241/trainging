<?php

use App\Models\Certificate;
use App\Models\News;
use App\Models\Person;
use App\Models\Program;
use App\Models\RequestCard;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/signup', function (Request $request) {
    $email = Person::where('email', '=', $request->input('email'))->firsr();
    if (!$email) {
        $user = new Person();
        $user->firstName = $request->input('firstName');
        $user->middleName = $request->input('middleName');
        $user->lastName = $request->input('lastName');
        $user->studentId = $request->input('studentId');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->universitry = $request->input('universitry');
        $user->college = $request->input('college');
        $user->gpa = $request->input('gpa');
        $user->password = $request->input('password');

        if ($user->save()) {
            unset($user->password);
            return Response::json(
                $user,
                200
            );
        } else {
            return Response::json(
                ['error' => 'can not save user'],
                202
            );
        }
    } else {
        return Response::json(['error' => 'email already exist'], 201);
    }
});



Route::post('/login', function (Request $request) {

    $email =  $request->input('email');
    $password = $request->input('password');
    $user =  Person::where('email', '=', $email)->where('password', '=', $password)->first();
    if ($user) {
        unset($user->password);
        return Response::json(
            $user,
            200
        );
    } else {
        return Response::json(['error' => 'User not found'], 404);
    }
});


Route::post('/profile', function (Request $request) {
    $id =  $request->input('id');
    $user =  Person::where('id', '=', $id)->first();
    if ($user) {
        $programs = Program::where('userId', '=', $user->id)->get();
        foreach ($programs as $program) {
            $days = strtotime($program->endTraining) - strtotime($program->startTraining);
            $spent = date('m/d/Y') - strtotime($program->startTraining);
            $program->complete = $spent * 100 / $days;
        }
        unset($user->password);
        $res = [
            $user,
            $programs
        ];
        return Response::json(
            $res,
            200
        );
    } else {
        return Response::json(['error' => 'User not found'], 404);
    }
});


Route::post('/editProfile', function (Request $request) {
    $id =  $request->input('id');
    $user =  Person::where('id', '=', $id)->first();
    if ($user) {
        if ($request->has('firstName')) $user->firstName = $request->input('firstName');
        if ($request->has('lastName')) $user->lastName = $request->input('lastName');
        if ($request->has('middleName')) $user->middleName = $request->input('middleName');
        if ($request->has('studentId')) $user->studentId = $request->input('studentId');
        if ($request->has('email')) $user->email = $request->input('email');
        if ($request->has('phone')) $user->phone = $request->input('phone');
        if ($request->has('universitry')) $user->universitry = $request->input('universitry');
        if ($request->has('college')) $user->college = $request->input('college');
        if ($request->has('gpa')) $user->gpa = $request->input('gpa');
        if ($request->has('password')) $user->password = $request->input('password');


        if ($request->has('profileGroup')) $user->profileGroup = $request->input('profileGroup');
        if ($request->has('country')) $user->country = $request->input('country');

        if ($request->has('nationalId')) $user->nationalId = $request->input('nationalId');
        if ($request->has('grandFather')) $user->grandFather = $request->input('grandFather');
        if ($request->has('fullName')) $user->fullName = $request->input('fullName');

        if ($request->has('gender')) $user->gender = $request->input('gender');
        if ($request->has('degree')) $user->degree = $request->input('degree');
        if ($request->has('term')) $user->term = $request->input('term');

        if ($request->has('year')) $user->year = $request->input('year');
        if ($request->has('hours')) $user->hours = $request->input('hours');
        if ($request->has('supervisorName')) $user->supervisorName = $request->input('supervisorName');

        if ($request->has('supervisorPhone')) $user->supervisorPhone = $request->input('supervisorPhone');
        if ($request->has('startTraining')) $user->startTraining = $request->input('startTraining');
        if ($request->has('endTraining')) $user->endTraining = $request->input('endTraining');

        if ($file = $request->file('image')) {

            $imageName = $file->time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
            $user->image = $imageName;
        }

        if ($file = $request->file('ar')) {

            $imageName = $file->time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
            $user->ar = $imageName;
        }

        if ($file = $request->file('cv')) {

            $imageName = $file->time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
            $user->cv = $imageName;
        }

        if ($file = $request->file('er')) {

            $imageName = $file->time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
            $user->er = $imageName;
        }
        if ($file = $request->file('tr')) {

            $imageName = $file->time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
            $user->tr = $imageName;
        }


        if ($user->update()) {
            unset($user->password);
            return Response::json(
                $user,
                200
            );
        } else {
            return Response::json(['error' => 'Error updating profile'], 201);
        }
    } else {
        return Response::json(['error' => 'User not found'], 404);
    }
});


Route::post('/home', function (Request $request) {
    $id =  $request->input('id');
    $user =  Person::where('id', '=', $id)->first();
    if ($user) {
        $programs = Program::where('userId', '=', $user->id)->get();
        foreach ($programs as $program) {
            $days = strtotime($program->endTraining) - strtotime($program->startTraining);
            $spent = date('m/d/Y') - strtotime($program->startTraining);
            $program->complete = $spent * 100 / $days;
        }

        $news = News::all();
        $res = [
            $programs,
            $news
        ];

        return Response::json(
            $res,
            200
        );
    } else {
        return Response::json(['error' => 'User not found'], 404);
    }
});


Route::post('/register', function (Request $request) {
    $id = $request->input('id');
    $user = Person::where('id', '=', $id)->first();
    if ($user) {
        $program = new Program();
        $program->userId = $id;
        $program->special = $request->input('special');
        $program->term = $request->input('term');
        $program->year = $request->input('year');
        $program->startTraining = $request->input('startTraining');
        $program->endTraining = $request->input('endTraining');

        if ($program->save()) {
            return Response::json(
                $user,
                200
            );
        } else {
            return Response::json(['error' => 'Error saving program'], 201);
        }
    } else {
        return Response::json(['error' => 'User not found'], 404);
    }
});



Route::post('/requestId', function (Request $request) {
    $id = $request->input('id');
    $user = Person::where('id', '=', $id)->first();
    if ($user) {
        $program = new Program();
        $program->userId = $id;
        $program->special = $request->input('special');
        $program->term = $request->input('term');
        $program->year = $request->input('year');
        $program->startTraining = $request->input('startTraining');
        $program->endTraining = $request->input('endTraining');

        if ($program->save()) {
            return Response::json(
                $program,
                200
            );
        } else {
            return Response::json(['error' => 'Error saving program'], 201);
        }
    } else {
        return Response::json(['error' => 'User not found'], 404);
    }
});


Route::post('/requestCard', function (Request $request) {
    $id = $request->input('id');
    $user = Person::where('id', '=', $id)->first();
    if ($user) {
        $requestCard = new RequestCard();
        $requestCard->userId = $id;
        $requestCard->contract = $request->input('contract');
        $requestCard->file = $request->input('file');
        $requestCard->job = $request->input('job');

        if ($requestCard->save()) {
            return Response::json(
                $requestCard,
                200
            );
        } else {
            return Response::json(['error' => 'Error saving Request'], 201);
        }
    } else {
        return Response::json(['error' => 'User not found'], 404);
    }
});


Route::post('/cancel', function (Request $request) {
    $programId = $request->input('programId');
    $program = Program::where('id', '=', $programId)->first();

    $program->status = "pause";

    if ($program->update()) {
        return Response::json(
            $program,
            200
        );
    } else {
        return Response::json(['error' => 'Error updating Program'], 201);
    }
});


Route::post('/continue', function (Request $request) {
    $programId = $request->input('programId');
    $program = Program::where('id', '=', $programId)->first();

    $program->status = "continue";

    if ($program->update()) {
        return Response::json(
            $program,
            200
        );
    } else {
        return Response::json(['error' => 'Error updating Program'], 201);
    }
});

Route::post('/getCertifiacte', function (Request $request) {
    $id = $request->input('id');
    $user = Person::where('id', '=', $id)->first();

    $programId = $request->input('programId');

    $certificate = new Certificate();
    $certificate->userId = $id;
    $certificate->programId = $programId;


    if ($file = $request->file('clearance')) {
        $imageName = $file->time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $imageName);
        $certificate->clearance = $imageName;
    } else {
        return Response::json(['error' => 'Please Upload your clearance'], 403);
    }


    if ($certificate->save()) {
        return Response::json(
            $certificate,
            200
        );
    } else {
        return Response::json(['error' => 'Error Saving Request'], 201);
    }
});


Route::post('/addNews' , function(Request $request){
    $news = new News();
    $news->body = $request->input('body');
    if($news->save()){
        return Response::json(
            $news,
            200
        );
    }else{
        return Response::json(['error' => 'Can not add news'], 201);
    }
});


Route::post('trainees' , function(Request $request){
    $users = Person::all();
    return Response::json(
        $users,
        200
    );
});


Route::post('trainignRequests' , function(Request $request){
    $programs = Program::where('status' , '=' , 'pending')->get();
    $users = [];
    $i = 0;
    foreach($programs as $program){
        $user = Person::where('id' , '=' , $program->userId)->first();
        $users[$i] = $user;
        $i = $i + 1;
    }
    $res = [
        $programs,
        $users
    ];
    return Response::json(
        $res,
        200
    );
});



Route::post('acceptTrainer' , function(Request $request){
    
    $programId = $request->input('programId');

    $program = Program::where('id' , '=' , $programId)->first();
    $program->status = "continue";

    if($program->update()){
        return Response::json(
            $program,
            200
        );
    }else{
        return Response::json(['error' => 'Error updating program'], 201);
    }
});


Route::post('cancelTrainer' , function(Request $request){
    
    $programId = $request->input('programId');

    $program = Program::where('id' , '=' , $programId)->first();
    

    if($program->delete()){
        return Response::json(
            $program,
            200
        );
    }else{
        return Response::json(['error' => 'Error deleting program'], 201);
    }
});