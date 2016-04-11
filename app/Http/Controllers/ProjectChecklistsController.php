<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Entities\{ Project, ProjectWork, Checklist, ProjectChecklist };

class ProjectChecklistsController extends Controller
{
    public function index($projectId, Request $request)
    {
        $project = Project::findOrFail($projectId);

        if ($request->ajax()) {
            $query = $project->checklists();

            if ($request->query('date')) {
                $query->whereDate('created_at', '=', new Carbon($request->query('date')));
            }

            $checklists = $query->get();

            return response()->json(compact('checklists'));
        }

        $checklists = $project->checklists()->whereHas('checkitems', function ($q) {
            $q->wherePasses(null);
        })->get();

        return view('project-checklists.index')
            ->withProject($project)
            ->withChecklists($checklists);
    }

    public function create($projectId)
    {
        $project = Project::findOrFail($projectId);

        $checklists = Checklist::all();

        return view('project-checklists.create')
            ->withProject($project)
            ->withChecklists($checklists);
    }

    public function store($projectId, Request $request)
    {
        $this->validate($request, [
            'work_id' => 'required',
            'name' => 'required',
            'seat' => 'required'
        ]);

        $project = Project::findOrFail($projectId);

        $projectWork = ProjectWork::findOrFail($request->input('work_id'));
        $referencedChecklist = $projectWork->workflow->checklist;

        $checklist = $project->checklists()->create([
            'name' => $request->name,
            'seat' => $request->seat,
            'passes_amount' => 0
        ]);

        if ($referencedChecklist) {
            foreach ($referencedChecklist->checkitems as $checkitem) {
                $checklist->checkitems()->create([
                    'name' => $checkitem->name,
                    'detail' => $checkitem->detail
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json(compact('checklist'));
        }

        return redirect()->route('projects.checklists.show', [$projectId, $checklist->id]);
    }

    public function show($projectId, $checklistId)
    {
        $project = Project::findOrFail($projectId);

        $checklist = ProjectChecklist::findOrFail($checklistId);

        return view('project-checklists.show')
            ->withProject($project)
            ->withChecklist($checklist);
    }

    public function updateCheckitemsResults($projectId, $checklistId, Request $request)
    {
        $checklist = ProjectChecklist::findOrFail($checklistId);

        $checklist->update([
            'passes_amount' => $request->passes_amount
        ]);

        $checklist->checkitems->each(function ($checkitem) use ($request) {
            $checkitem->update([
                'passes' => $request->passes[$checkitem->id]
            ]);

            if (!is_null($checkitem->passes) && !$checkitem->passes) {
                $checkitem->faultImprovement()->create([]);
            } else {
                if ($checkitem->faultImprovement) {
                    $checkitem->faultImprovement->delete();
                }
            }
        });

        return redirect()->route('projects.checklists.show', [$projectId, $checklistId]);
    }
}
