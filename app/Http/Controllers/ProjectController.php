<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    //
    public function getAll()
    {
        return Project::with("client")->get();
    }

    public function getById($id)
    {
        return Project::find($id);
    }

    public function create(Request $request)
    {

        $user = Auth::user();

        $project = array_merge($request->all(),['user_id'=>$user->id]);
        return Project::create($project);
    }

    public function getByUserId($id)
    {
        $user = Auth::user();
        $projects = $user->projects->load("client");

        return $projects;

    }

    public function deleteById($id)
    {
        $project = Project::find($id);
        if (isset($project)) {
            $project->delete();
            return $project;
        } else {
            return response()->json(['error' => 'Project don\'t exists.'], 404);
        }

    }

    public function finalBudget($id)
    {
        $mpdf                     = new Mpdf();
        $project = Project::find($id);
        $tasks                    = $project->tasks()->where("status","C")->get();

        $projectCost = $project->cost_per_hour;
        $client = $project->client;

        $logoSrc = public_path().'\img\logo.png';
        $img = '<div style="text-align:center; margin:20px"><img width="100px"  src="'.$logoSrc.'"/></div>';
        $mpdf->WriteHTML($img);
        $pdfHeader = "
        <table cellpadding='5px' autosize='1' width='100%'
        style='background:rgb(25,50,75);
        overflow: wrap;
        border-collapse: collapse;
        color:rgb(255,255,255);
        font-size:0.7em'>
        <tbody >
        <tr>
        <td width='50%'>Nombre del proyecto: $project->title</td>
        <td align='right'>Nombre del cliente: $client->name</td>
        </tr>
        <tr>

        <td align='right' colspan='2'>Tipo cliente: $client->type</td>
        </tr>

        </tbody>
        </table>";
        $mpdf->WriteHTML($pdfHeader);
        $mpdf->WriteHTML("<div ><h3>Tareas:</h3></div>");

        $thead="<tr><th>Titulo</th>
        <th>Descripcion</th>
        <th>Duracion</th>
        <th>Coste</th></tr>";
        $tbody = "";
        $totalCost = 0;
        foreach($tasks as $task){
            if($task->status == "C"){
                $taskCost = $task->duration*$projectCost;
                $totalCost+=$taskCost;
                $tbody .= "<tr>
                <td>$task->title</td>
                <td>$task->description</td>
                <td>$task->duration horas</td>
                <td>$taskCost €</td>
                </tr>";
            }
        }
        $tbody.="<tr><th colspan='3' align='right'>Total:</th><td>$totalCost €</td></tr>";
        $table ="<table cellpadding='5px' autosize='1' border='1' width='100%' style='overflow: wrap;border-collapse: collapse;'><thead>$thead</thead><tbody>$tbody</tbody></table>";

        $html =
        "<html>
            <head>
            <style>
            td{
                font-size:0.8em
            }
            </style>
            </head>
            <body>$table</body>
        </html>";
        $mpdf->WriteHTML($html);
        header("Access-Control-Allow-Origin: *");
        $mpdf->Output('justificante.pdf', 'I');
    }
    public function estimatedBudget($id)
    {
        $mpdf                     = new Mpdf();
        $project = Project::find($id);
        $tasks                    = $project->tasks;

        $projectCost = $project->cost_per_hour;
        $client = $project->client;

        $logoSrc = public_path().'\img\logo.png';
        $img = '<div style="text-align:center; margin:20px"><img width="100px"  src="'.$logoSrc.'"/></div>';
        $mpdf->WriteHTML($img);
        $pdfHeader = "<table cellpadding='5px' autosize='1' width='100%'
        style='background:rgb(25,50,75);
        overflow: wrap;
        border-collapse: collapse;
        color:rgb(255,255,255);
        font-size:0.7em'>
        <tbody >
        <tr>
        <td width='50%'>Nombre del proyecto: $project->title</td>
        <td align='right'>Nombre del cliente: $client->name</td>
        </tr>
        <tr>

        <td align='right' colspan='2'>Tipo cliente: $client->type</td>
        </tr>

        </tbody>
        </table>";
        $mpdf->WriteHTML($pdfHeader);
        $mpdf->WriteHTML("<div ><h3>Tareas:</h3></div>");

        $thead="<tr><th>Titulo</th>
        <th>Descripcion</th>
        <th>Duracion</th>
        <th>Coste</th></tr>";
        $tbody = "";
        $totalCost = 0;
        foreach($tasks as $task){
            if($task->status == "C"){
                $taskCost = $task->duration*$projectCost;
                $totalCost+=$taskCost;
                $tbody .= "<tr>
                <td>$task->title</td>
                <td>$task->description</td>
                <td>$task->duration horas</td>
                <td>$taskCost €</td>
                </tr>";
            }
        }
        $tbody.="<tr><th colspan='3' align='right'>Total:</th><td>$totalCost €</td></tr>";
        $table ="<table cellpadding='5px' autosize='1' border='1' width='100%' style='overflow: wrap;border-collapse: collapse;'><thead>$thead</thead><tbody>$tbody</tbody></table>";

        $html =
        "<html>
            <head>
            <style>
            td{
                font-size:0.8em
            }
            </style>
            </head>
            <body>$table</body>
        </html>";
        $mpdf->WriteHTML($html);
        header("Access-Control-Allow-Origin: *");
        $mpdf->Output('justificante.pdf', 'I');
    }

    public function update(Request $request){
        $project = Project::find($request->id);
        $input = $request->all();
        if(isset($project)){
            $project->fill($input)->save();
            return response()->json(['success'=>$project]);
        }else{
            return response()->json(['error' => 'Project doesn\'t exists.'], 404);
        }
    }

}
