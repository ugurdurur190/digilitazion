<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCancellation;
use App\Models\ProjectSituation;
use App\Models\ProjectSituationActivite;
use App\Models\ProjectComment;
use App\Models\ProjectAffectedUnit;
use App\Models\ProjectAnswer;
use App\Models\ProjectCurrentProcess;
use App\Models\ProjectCurrentProcessAnswers;
use App\Models\ProjectQuestion;
use App\Models\ProjectVote;
use App\Models\ProjectVoteQuestion;
use App\Models\ProjectWorkTeam;
use App\Models\ProjectTodo;
use App\Models\ProjectActivite;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail as FacadesMail;

class ProjectController extends Controller
{

  public function __construct()
   {
       $this->middleware('auth');

   }
   
    public function storeProject(Request $request)
    {
      if($request->questionCount != 0 || $request->processCount !=0){
        //new project
        $project = new Project;
        $project->user_id = $request->userId;
        $project->unit_id = $request->unit_id;
        $project->title = $request->title;
        $project->description = $request->description;
        $project->score = $request->score;
        if(!empty($request->score)){

         $project->state_id = 2;
         $project->save();

         $situationActivite = new ProjectSituationActivite;
         $situationActivite->project_id = $project->id;
         $situationActivite->user_id = $project->user_id;
         $situationActivite->state_id = $project->state_id;
         $situationActivite->comment = "Devam Eden Proje";
         $situationActivite->save();
        }else{
         $project->save();
        }

        //project question store
        for($i=0;$i<$request->questionCount;$i++){
          $question=new ProjectQuestion;
          $question->project_id=$project->id;
          $question->question=$request->question[$i];
          $question->type=$request->type[$i];
          if($question->type=='radio_opt' || $question->type=='check_opt'){
            $question->frm_option = $request->frm_option[$i];
          }
          else{
              $question->frm_option = '';
          }
          $question->save();

          //project answer store
          $answer=new ProjectAnswer;
          $answer->project_id=$project->id;
          $answer->question_id=$question->id;
          if($question->type=='textfield_s'){
            $t="text".$request->question_id[$i];
            $answer->answer=$request->$t;
          }
          elseif($question->type=='radio_opt'){
            $r="radio".$request->question_id[$i];
            $answer->answer=$request->$r;
          }
          elseif($question->type=='check_opt'){
            $c=$request->input('checkBox'.$request->question_id[$i]);
            $answer->answer=implode("|",$c);
          }
          $answer->save();
        }

        //project current process store
        for($i=0;$i<$request->processCount;$i++){
          $process=new ProjectCurrentProcess;
          $process->project_id=$project->id;
          $process->process=$request->process[$i];
          $process->title=$request->process_title[$i];
          $process->save();

          $processAnswer=new ProjectCurrentProcessAnswers;
          $processAnswer->project_id=$project->id;
          $processAnswer->current_process_id=$process->id;
          $pa=$request->input('answer'.$request->process_id[$i]);
          $processAnswer->answer=implode("|",$pa);
          $processAnswer->save();
        }

        for($i=0;$i<count($request->input('unit'));$i++){
          $unit = new ProjectAffectedUnit;
          $unit->project_id = $project->id;
          $u=$request->input('unit')[$i];
          $unit->affected_units_id=$u;
          if(empty($project->score)){
            $unit->approval = 0;
          }else{
            $unit->approval = 1;
          }
            
          
          $unit->save();

          if(empty($request->score)){
            $users = User::where('unit_id',$unit->affected_units_id)->get();
            //project affected unit
            $unitUser = Unit::where('id',$unit->affected_units_id)->value('unit');
            //project unit
            $projectUnit = Unit::where('id',$project->unit_id)->value('unit');
            //project owner
            $projectUser = User::where('id',$project->user_id)->value('name');
            foreach($users as $user){
              FacadesMail::raw("Proje sahibi: '$projectUser' Proje birimi: '$projectUnit' olan '$project->title' projesi'nin, etkilenen birimlerine dahilsiniz '$unitUser' birimi olarak birim onayınızı düzenleyiniz! ",function($message) use ($user){
                  $message->to($user->email)->subject('Dijitalleşme Projeleri Etkilenen Birim Onay Uyarısı');
              });
            }
          }

        }

        
        $voteQuestions=array('Dijitaleşme Projesi mi?','Uygulanabilir mi?','Gerekli mi?',
            'Vizyon ve Misyona Uygun mu?','Ciroya Etki','İç/Dış müşteri gerekliliği ve termini',
            'Rekabete Etkisi','İş gücü kesintisi önleyecek seviyede bir gereklilik mi?',
            'Regülasyon gerekliliği ve termini','Zaman','Kaynak','Maliyet','Optimizasyon Seviyesi','Dış kaynak alternatifi var mı? / Yenilikçi yönü');
            foreach($voteQuestions as $voteQuestion){
              $projectVoteQuestions = new ProjectVoteQuestion;
              $projectVoteQuestions->project_id = $project->id;
              $projectVoteQuestions->question = $voteQuestion;
              if(!empty($request->score)){
               $projectVoteQuestions->state = 1;
              }
              $projectVoteQuestions->save();
            }

            $teams = new ProjectWorkTeam;
            $teams->project_id = $project->id;
            $teams->user_id = $project->user_id;
            $teams->authorization = 1;
            $teams->save();
            
            if(empty($project->score)){
               return Redirect::to('projects/list')->with('success', 'Proje Kaydedildi!');
            }else{
               return Redirect::to('projects/continues/list')->with('success', 'Proje Kaydedildi!');
            }
            
      }
      else{
        return Redirect::to('forms/view/'.$request->formId)->with('warning', 'Admin en az bir soru veya mevcut süreç eklemeli!');
      }

    }


    public function listProject()
    {
      $projects = Project::where('state_id',null)->orWhere('state_id',1)->get();
      $canceledProjects = ProjectCancellation::all();
      $situations = ProjectSituation::all();
      $users = User::all();
      $voteDone=ProjectVote::distinct()->where('user_id',Auth::user()->id)->pluck('project_id')->toArray();
      $votes = ProjectVote::all();
      $voteQuestions = ProjectVoteQuestion::all();

      return view('projects.project-list',["projects" => $projects, "canceledProjects" => $canceledProjects, "situations" => $situations, "users" => $users, "voteDone"=>$voteDone , "votes" => $votes, "voteQuestions" => $voteQuestions]);
    }

    public function listContiunesProject()
    {
      $projects = Project::where('state_id',2)->get();
      $situations = ProjectSituation::all();
      $users = User::all();
      $votes = ProjectVote::all();
      $voteQuestions = ProjectVoteQuestion::all();

      return view('projects.continues-project-list',["projects" => $projects, "situations" => $situations, "users" => $users, "votes" => $votes, "voteQuestions" => $voteQuestions]);
    }


    public function listCompletedProject()
    {
      $projects = Project::where('state_id',3)->get();
      $situations = ProjectSituation::all();
      $users = User::all();
      $votes = ProjectVote::all();
      $voteQuestions = ProjectVoteQuestion::all();
      
      return view('projects.completed-project-list',["projects" => $projects, "situations" => $situations, "users" => $users, "votes" => $votes, "voteQuestions" => $voteQuestions]);
    }

    public function listCanceledProject()
    {
      $projects = Project::where('state_id',4)->get();
      $situations = ProjectSituation::all();
      $users = User::all();
      $votes = ProjectVote::all();
      $voteQuestions = ProjectVoteQuestion::all();
      
      return view('projects.canceled-project-list',["projects" => $projects, "situations" => $situations, "users" => $users, "votes" => $votes, "voteQuestions" => $voteQuestions]);
    }


    public function filterProject($id)
    {
      $project = Project::find($id);
      switch($project->state_id){
         case 1:
            $situations = ProjectSituation::where('id','<>',1)->where('id','<>',3)->get();
            break;
         case 2:
            $situations = ProjectSituation::where('id','<>',1)->where('id','<>',2)->get();
            break;
         case 3:
            $situations = ProjectSituation::where('id',4)->get();
            break;
         case 4:
            $situations = ProjectSituation::where('id',1)->get();
            break;
      }
      return view('projects.project-situation-filters',["project" => $project, "situations" => $situations]);
    }


    public function editStatus(Request $request,$id)
    {
      $project = Project::find($id);
      $project->state_id = $request->state_id;
      if($project->state_id == 1){
         $canceledProject = new ProjectCancellation;
         $canceledProject->project_id = $project->id;
         if(!empty($project->score)){
            $canceledProject->score = $project->score;
         }
         else{
            $votes = ProjectVote::all();
            $projectVote = $votes->where('project_id',$project->id)->count();
            $voteQuestions = ProjectVoteQuestion::all();
            if($projectVote != 0){
               $canceledProject->score = round((($votes->where('project_id',$project->id)->where('privilege_id','<>',3)->sum('vote')+($votes->where('project_id',$project->id)->where('privilege_id',3)->sum('vote')*10))*100) / (($voteQuestions->where('project_id',$project->id)->where('state',1)->count()*5)*(($votes->where('project_id',$project->id)->where('privilege_id','<>',3)->unique('user_id')->count())+($votes->where('project_id',$project->id)->where('privilege_id',3)->unique('user_id')->count()*10))),0);
            }else{
               $canceledProject->score = 0;
            }
         }

         ProjectCancellation::where('project_id',$project->id)->delete();
         if( ! $canceledProject->save()){
            App::abort(500, 'Error');
         }else{
            ProjectVote::where('project_id',$project->id)->delete();
         }
         
         $project->score = null;
      }



      if ( ! $project->save())
      {
         App::abort(500, 'Error');
      }
      else{
         $situationActivite = new ProjectSituationActivite;
         $situationActivite->project_id = $id;
         $situationActivite->user_id = Auth::user()->id;
         $situationActivite->state_id = $request->state_id;
         $situationActivite->comment = $request->stateComment;
         $situationActivite->save();

         switch($request->state_id){
            case 1:
               return Redirect::to('projects/list')->with('success', 'Proje Durumu Güncellendi!');
               break;
            case 2:
               return Redirect::to('projects/continues/list')->with('success', 'Proje Durumu Güncellendi!');
               break;
            case 3:
               return Redirect::to('projects/completed/list')->with('success', 'Proje Durumu Güncellendi!');
               break;
            case 4:
               return Redirect::to('projects/canceled/list')->with('success', 'Proje Durumu Güncellendi!');
               break;
         }
      }
    }

    public function viewProjectFilterActivite($id)
    {
      $project = Project::find($id);
      $situations = ProjectSituation::all();
      $users = User::all();
      $activites = ProjectSituationActivite::where('project_id',$id)->get();
      $comments = ProjectComment::where('project_id',$id)->get();
      return view('projects.project-situation-activite-view',["project" => $project, "situations" => $situations, "users" => $users, "activites" => $activites, "comments" => $comments]);
    }


    public function storeComment(Request $request,$id)
    {
      $comment = new ProjectComment;
      $comment->project_id = $id;
      $comment->user_id = Auth::user()->id;
      $comment->comment = $request->comment;
      if(! $comment->save()){
         App::abort(500, 'Error');
      }else{
         return Redirect::to('projects/situations/filters/activites/'.$id)->with('success', "Yorum Gönderildi!");
      }
    }
    
    public function viewProject($id)
    {
      $projects = Project::all()->find($id);
      $questions = ProjectQuestion::where('project_id',$id)->get();
      $answers = ProjectAnswer::where("project_id",$id)->get();
      $processes = ProjectCurrentProcess::where("project_id",$id)->get();
      $processAnswers = ProjectCurrentProcessAnswers::where("project_id",$id)->get();
      $affectedUnits = ProjectAffectedUnit::where("project_id",$id)->get();
      $users = User::all();
      $units = Unit::all();

      if(isset($projects)){
         return view('projects.project-view',["questions" => $questions, "answers" => $answers, "processes" => $processes, "processAnswers" => $processAnswers, "users" => $users, "projects" => $projects, "units" => $units, "affectedUnits" => $affectedUnits]);
      }
      else{
         return Redirect::to('projects/list')->with('warning', 'Böyle bir proje yok!');
      }
    }

   public function deleteProject($id)
   {
      $projects = Project::find($id);

      if ( ! $projects->delete())
      {
         App::abort(500, 'Error');
      }
      else{
         return Redirect::back()->with('success', 'Proje silindi!');
      }
   }


   public function unitApproval($id)
   {
      $projects = Project::all()->find($id);
      if(isset($projects)){
         if($projects->state_id == null || $projects->state_id == 1){
            $affectedUnits=ProjectaffectedUnit::where('project_id',$id)->get();
            $units = Unit::all();
            $users = User::all();
            return view('projects.project-unitApproval',["projects" => $projects, "affectedUnits" => $affectedUnits, "units" => $units, "users" => $users]);
         }
         else{
            return Redirect::to('projects/list')->with('warning', 'Proje Fikir Veya Oylama Aşamasında Değil. Birim Onayları Değiştirilemez!');
         }
      }
      else{
         return Redirect::to('projects/list')->with('warning', 'Böyle bir proje yok!');
      }
   }



   public function storeUnitApproval(Request $request,$id)
   {
      $unitApproval=ProjectAffectedUnit::find($id);
      $approval="approval$unitApproval->affected_units_id";
      $unitApproval->approval = $request->$approval;

      //Affected Unit user count
      $unitUserCount = User::where('unit_id',$unitApproval->affected_units_id)->count();
      //Affected Unit name (mail send)
      $affectedUnitName = Unit::where('id',$unitApproval->affected_units_id)->value('unit');
      //Project Affected Unit name
      $projectUnit = Unit::where('id',Project::where('id',$request->project_id)->value('unit_id'))->value('unit');

      if ( ! $unitApproval->save())
      {
         App::abort(500, 'Error');
      }
      else{
        //Project Owner
        $projectOwner=User::where('id',Project::where('id',$request->project_id)->value('user_id'))->value('name');
        $projectTitle=Project::where('id',$request->project_id)->value('title');
        
         if($unitUserCount > 1){
            $users = User::where('unit_id',$unitApproval->affected_units_id)->get();
            $approverEmail = Auth::user()->email;
            foreach($users as $user){
               FacadesMail::raw("Proje sahibi: $projectOwner , Proje birimi: $projectUnit , Olan $projectTitle projesi'nin , $affectedUnitName birim onayı , $approverEmail tarafından Düzenlenmiştir! ",function($message) use ($user){
                  $message->to($user->email)->subject('Dijitalleşme Projeleri Etkilenen Birim Onay Uyarısı');
               });
            }
         }

         return Redirect::to('projects/units/approval/'.$unitApproval->project_id)->with('success', "Birim Onayı Kaydedildi!");
      }
   }


   public function manageVoteQuestions($id)
   {
      $projects = Project::all()->find($id);
      if(isset($projects)){
         if($projects->state_id == null){
            $affectedUnits=ProjectAffectedUnit::where('project_id',$id)->get();
            $units = Unit::all();
            $users = User::all();
            $projectVoteQuestions = ProjectVoteQuestion::where('project_id',$id)->get();

            return view('projects.project-voteQuestionManage',["projects" => $projects, "affectedUnits" => $affectedUnits, "units" => $units, "users" => $users, "projectVoteQuestions"=>$projectVoteQuestions]);
         }
         else{
            return Redirect::to('projects/list')->with('warning', 'Proje Oylama Aşamasında. Düzenleme Yapılamaz!');
         }
      }
      else{
         return Redirect::to('projects/list')->with('warning', 'Böyle bir proje yok!');
      }
   }


   public function storeVoteQuestion(Request $request)
   {
        $voteQuestion=new ProjectVoteQuestion;
        $voteQuestion->project_id=$request->project_id;
        $voteQuestion->question=$request->voteQuestion;

        if ( ! $voteQuestion->save())
        {
           App::abort(500, 'Error');
        }
        else{
           return Redirect::to('projects/votes/questions/manage/'.$request->project_id)->with('success', 'Soru Eklendi!');
        }
   }

   public function selectQuestion(Request $request)
   {
      for($i=0;$i<count($request->input('projectVoteQuestions'));$i++){
         $qst=$request->input('projectVoteQuestions')[$i];
         $question = ProjectVoteQuestion::find($qst);
         $question->state = 1;
         $question->save();
      }

      $project = Project::find($request->project_id);
      $project->state_id = 1;
      if(! $project->save()){
         App::abort(500, 'Error');
      }else{
         $allUsers = User::all();
         $projectOwner=User::where('id',Project::where('id',$request->project_id)->value('user_id'))->value('name');
         $projectTitle=Project::where('id',$request->project_id)->value('title');
         $projectUnit = Unit::where('id',Project::where('id',$request->project_id)->value('unit_id'))->value('unit');

         foreach($allUsers as $allUser){
            FacadesMail::raw("Proje sahibi: '$projectOwner' , Proje birimi: '$projectUnit' , Olan '$projectTitle' projesi oylamaya açılmıştır. Lütfen projeyi oylayınız!",function($message) use ($allUser){
               $message->to($allUser->email)->subject('Dijitalleşme Projeleri Oylamaya Açık Uyarısı');
            });
         }
         return Redirect::to('projects/list')->with('success', 'Proje Oylama Açıldı!');
      }
   }


   public function voteProject($id)
   {
      $projects = Project::all()->find($id);
      if(isset($projects)){
         if($projects->state_id == 1){
            $projectVoteQuestions = ProjectVoteQuestion::where(['project_id' => $id, 'state' => 1])->get();
            $projectDone=ProjectVote::where(['project_id' => $id, 'user_id' => Auth::user()->id])->count();
            $affectedUnits=ProjectAffectedUnit::where('project_id',$id)->get();
            $votes = ProjectVote::where(['project_id' => $id, 'user_id' => Auth::user()->id])->get();
            $units = Unit::all();
            $users = User::all();
            return view('projects.project-vote',["projects" => $projects, "projectDone" => $projectDone, "affectedUnits" => $affectedUnits, "votes" => $votes, "units" => $units, "projectVoteQuestions"=>$projectVoteQuestions, "users" => $users]);
         }
         else{
            return Redirect::to('projects/list')->with('warning', 'Proje Oylama Aşamasında Değil, Oylanamaz!');
         }
      }
      else{
         return Redirect::to('projects/list')->with('warning', 'Böyle bir proje yok!');
      }
   }


   public function storeVote(Request $request,$id)
   {
      $projectVoteQuestions = ProjectVoteQuestion::where(['project_id' => $id, 'state' => 1])->count();
      for($i=0;$i<$projectVoteQuestions;$i++){
         $votes=new ProjectVote;
         $votes->project_id=$id;
         $votes->user_id=Auth::user()->id;
         $votes->user_email=Auth::user()->email;
         $votes->privilege_id=Auth::user()->privilege_id;
         $votes->question_id=$request->questionId[$i];
      
         $v="vote$i";
         $votes->vote=$request->$v;
            
         $votes->save();
      }
         return Redirect::to('projects/list')->with('success', 'Oylar Gönderildi!');
   }


   public function updateVote(Request $request,$id)
   {
      $projectVoteQuestions = ProjectVoteQuestion::where(['project_id' => $id, 'state' => 1])->count();
      for($i=0;$i<$projectVoteQuestions;$i++){
         $votes=ProjectVote::where(['project_id' => $id, 'user_id' => Auth::user()->id,'question_id' => $request->questionId[$i]])->first();
         $votes->project_id=$id;
         $votes->user_id=Auth::user()->id;
         $votes->user_email=Auth::user()->email;
         $votes->privilege_id=Auth::user()->privilege_id;
         $votes->question_id=$request->questionId[$i];
      
         $v="vote$i";
         $votes->vote=$request->$v;
            
         $votes->save();
      }
         return Redirect::to('projects/list')->with('success', 'Oylar Güncellendi!');
   }


   public function listVoteReport()
   {
      $projects = Project::where('state_id','<>',4)->get();
      $users = User::all();
      return view('projects.project-voteReport',["users" => $users, "projects" => $projects]);
   }

   

   public function viewVoteReport($id)
   {
      $votes=ProjectVote::where('project_id',$id)->get();
      $questionCount=ProjectVoteQuestion::where(['project_id' => $id, 'state' => 1])->count();
      $questionId=ProjectVote::distinct()->where('project_id',$id)->get('question_id')->toArray();
      if($questionId != null){
         for($i=0;$i<$questionCount;$i++){
            $voteExecutiveCount[$i]=ProjectVote::where(['project_id' => $id, 'question_id' => $questionId[$i]])->where('privilege_id','3')->count();
            $voteNormalCount[$i]=ProjectVote::where(['project_id' => $id, 'question_id' => $questionId[$i]])->where('privilege_id','<>','3')->count();
            for($j=1;$j<=5;$j++){
               $questionsExecutiveVoteCount[$i][$j]=(ProjectVote::where(['project_id' => $id, 'question_id' =>$questionId[$i],'vote' => $j])->where('privilege_id','3')->count());          
               $questionsNormalVoteCount[$i][$j]=(ProjectVote::where(['project_id' => $id, 'question_id' => $questionId[$i],'vote' => $j])->where('privilege_id','<>','3')->count());
               $voteRate[$i][$j]=((($questionsExecutiveVoteCount[$i][$j]*10)+($questionsNormalVoteCount[$i][$j]))/(($voteExecutiveCount[$i]*10)+$voteNormalCount[$i]))*100;
               $voteRate[$i][$j]=round($voteRate[$i][$j],0);
            }
         }
         
         
         $projects = Project::all()->find($id);
         $voteQuestions = ProjectVoteQuestion::where(['project_id' => $id, 'state' => 1])->get();
         $affectedUnits=ProjectAffectedUnit::where('project_id',$id)->get();
         $questions = ProjectQuestion::where("project_id",$id)->get();
         $answers = ProjectAnswer::where("project_id",$id)->get();
         $users = User::all();
         $units=Unit::all();
   
         return view('projects.project-voteReportView',["questions" => $questions, "answers" => $answers, "users" => $users, "projects" => $projects, "votes" => $votes, "questionCount" => $questionCount, "voteRate" => $voteRate, "units" => $units, "affectedUnits" => $affectedUnits, "voteQuestions" => $voteQuestions ]);
      }

      else{
         return Redirect::to('projects/votes/reports/list')->with('warning', 'Böyle bir proje oylaması yok!');
      }
      
      
   }

}