<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $categories = Category::select(['category'])->get()->sortBy('category');
        $projects = Project::select(['id', 'slug', 'main_image'])->with('categories')->get();

        return view('projects.index', compact('projects', 'categories'));
    }

    public function show($locale, $project_id)
    {
        //  I had to do this way. Possibly, service provider running Project $project (route model binding) first, then middleware
        //  As a result, Observer is setting locale which is not set yet
        $project = Project::findOrFail($project_id);
        $project->load('categories', 'project_contents');

        $nextProject = $this->getNextProject($project_id);
        $prevProject = $this->getPreviousProject($project_id);

        return view('projects.show', compact(
            'project',
            'nextProject',
            'prevProject'
        ));
    }

    /**
     * @param $projectId
     * @return Project
     */
    private function getNextProject($projectId): Project
    {
        $nextProject = Project::select(['id', 'slug'])
            ->where('id', '>', $projectId)
            ->orderBy('id')->first();
        $nextProject = $nextProject ?? Project::find(1);

        return $nextProject;
    }

    /**
     * @param $projectId
     * @return Project
     */
    private function getPreviousProject($projectId): Project
    {
        $prevProject = Project::select(['id', 'slug'])
            ->where('id', '<', $projectId)
            ->orderByDesc('id')->first();
        $prevProject = $prevProject ?? Project::select(['id', 'slug'])->orderByDesc('id')->first();

        return $prevProject;
    }

}