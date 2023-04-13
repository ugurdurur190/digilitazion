<?php
namespace App\Http\Controllers;

use Illuminate\Support\Benchmark;

use App\Models\Project;
use App\Models\ProjectAnswer;
use App\Models\ProjectVote;
use App\Models\ProjectVoteQuestion;
use App\Models\User;
use App\Models\Unit;

class IndexController extends Controller
{

   public function __construct()
   {
       $this->middleware('auth');

   }

   public function index()
   {
      //Controller.php methods
    $unapprovedProjectCount = $this->getUnapprovedProjectCount();
    $unratedProjectCount = $this->getUnratedProjectCount();
    return view('home-page',["unapprovedProjectCount"=>$unapprovedProjectCount, "unratedProjectCount"=>$unratedProjectCount]);
   }

   public function indexDashboard()
   {
      $answers = ProjectAnswer::all();
      $projects = Project::where('state_id','<>',4)->get();
      $voteQuestions = ProjectVoteQuestion::all();
      $units = Unit::all();
      $unitNames = Unit::pluck("unit");
      $users = User::all();
      $votes = ProjectVote::all();

      $projectCounts = array();
      foreach($units as $unit){
         $projectCount = Project::where('unit_id',$unit->id)->where('state_id','<>',4)->count();
         array_push($projectCounts,$projectCount);
      }

      return view('dashboard',["answers" => $answers, "users" => $users, "projects" => $projects, "voteQuestions" => $voteQuestions, "units" => $units, "unitNames" => $unitNames, "votes" => $votes, "projectCounts" => $projectCounts]);
   }


   public function viewUserGuide()
   {
    return view('user-guide');
   }

   public function viewVideo()
   {
      return view('video');
   }
   

}
 