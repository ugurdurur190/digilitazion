<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\ProjectAffectedUnit;
use App\Models\ProjectVote;
use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //get unapproved project
   public function getUnapprovedProjects()
   {
    $unapproved_projects = array();
    $affected_units = ProjectAffectedUnit::where(['affected_units_id' => Auth::user()->unit_id, 'approval' => 0])->get();
    foreach($affected_units as $affected_unit){
        $unapproved_project = Project::where('id',$affected_unit->project_id)->whereIn('state_id',[null,1])->first();
        if(!empty($unapproved_project)){
            array_push($unapproved_projects,$unapproved_project);
        }else{
            continue;
        }
    }

    return $unapproved_projects;

   }

   //get unrated projects
   public function getUnratedProjects()
   {
    $projects = Project::where("state_id",1)->get('id');
    $allowed_projects = array();
    $unrated_projects = array();

    foreach($projects as $project){
        array_push($allowed_projects,Project::where('id',$project->id)->first());
    }

    foreach($allowed_projects as $allowed_project){
        $vote = ProjectVote::where(["project_id" => $allowed_project->id, "user_id" => Auth::user()->id])->count();
        if($vote == 0){
            array_push($unrated_projects,$allowed_project);
        }else{
            continue;
        }
    }
    
    return $unrated_projects;
   }


   //Used in IndexController and CustomAuthController
   public function getUnapprovedProjectCount()
   {
    $unapprovedProjectCount = count($this->getUnapprovedProjects());
    return $unapprovedProjectCount;
   }

   public function getUnratedProjectCount()
   {
    $unratedProjectCount = count($this->getUnratedProjects());
    return $unratedProjectCount;
   }
}
