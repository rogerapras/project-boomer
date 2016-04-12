<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ConstructionDailiesController extends Controller
{
    public function index($projectId)
    {
        $project = \App\Entities\Project::findOrFail($projectId);

        return view('project-constructiondailies.index')
            ->withProject($project);
    }

    public function show($projectId, $date)
    {
        $project = \App\Entities\Project::findOrFail($projectId);

        return view('project-constructiondailies.show', compact('project', 'date'));
    }
}
