<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function getAllByProjectId($id){
        $project = Project::find($id);
        if(isset($project)){
            return $project->tasks;
        }else{
            return response()->json(['error' => 'Project don\'t exists.'], 404);
        }
    }
    public function getOneById($id){
        return Task::find($id);
    }

    public function create(Request $request){
        $project = Project::find($request->input("project_id"));
        if(isset($project)){
            $task = $request->all();
            $task['status'] = "IP"; //In Progress
            return Task::create($task);
        }else{
            return response()->json(['error' => 'Project doesn\'t exists.'], 404);
        }

    }
    public function deleteOne($id){
        $task = Task::find($id);
        if(isset($task)){
            $task->delete();
            return response()->json(['success'=>$task]);
        }else{
            return response()->json(['error' => 'Task doesn\'t exists.'], 404);
        }


    }
    public function update(Request $request){
        $task = Task::find($request->id);
        $input = $request->all();
        if(isset($task)){
            $task->fill($input)->save();
            return response()->json(['success'=>$task]);
        }else{
            return response()->json(['error' => 'Task doesn\'t exists.'], 404);
        }
    }

}
