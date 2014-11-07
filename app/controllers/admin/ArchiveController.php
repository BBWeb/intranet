<?php

class ArchiveController extends BaseController {

  private $project;

  public function __construct(Project $project)
  {
    $this->project = $project;
  }

  public function index()
  {
    $projects = $this->project->all();

    return View::make('admin.archive-projects', [
      'projects' => $projects
    ]);
  }

  public function updateArchivedProjects()
  {
    $projectsToArchive = Input::get('projects');

    $projects = $this->project->all();

    $projectsToUnarchive = $projects->filter(function($project) use (&$projectsToArchive) {
      return !array_key_exists($project->id, $projectsToArchive);
    });

    // unarchive projects
    $projectsToUnarchive->each(function($project) {
      $project->archive = false;
      $project->update();
    });

    // archive "checked" projects
    foreach ($projectsToArchive as $projectId => $val) {
      $project = $this->project->find($projectId);
      $project->archive = true;
      $project->update();
    }

    return Redirect::to('/archive');
  }

}