<?php
namespace App\Services\Production;

use App\Models\Task;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use App\Repositories\TaskTemplateRepositoryInterface;
use App\Services\ShiftServiceInterface;
use App\Services\TaskServiceInterface;
use App\Services\TimelineServiceInterface;
use LaravelRocket\Foundation\Exceptions\ClientErrorException;
use LaravelRocket\Foundation\Services\Production\BaseService;

class TaskService extends BaseService implements TaskServiceInterface
{
    /** @var \App\Repositories\TaskRepositoryInterface */
    protected $taskRepository;

    /** @var TaskTemplateRepositoryInterface $taskTemplateRepository */
    protected $taskTemplateRepository;

    /** @var ShiftServiceInterface $shiftService */
    protected $shiftService;
    /**
     * @var \App\Services\TimelineServiceInterface
     */
    private $timelineService;
    /**
     * @var \App\Repositories\PostRepositoryInterface
     */
    private $postRepository;

    public function __construct(
        TaskRepositoryInterface $taskRepository,
        TaskTemplateRepositoryInterface $taskTemplateRepository,
        ShiftServiceInterface $shiftService,
        TimelineServiceInterface $timelineService,
        PostRepositoryInterface $postRepository
    ) {
        $this->taskRepository         = $taskRepository;
        $this->taskTemplateRepository = $taskTemplateRepository;
        $this->shiftService           = $shiftService;
        $this->timelineService        = $timelineService;
        $this->postRepository         = $postRepository;
    }

    public function startTask($unit, $date, $index, $taskTemplateId, $startTime)
    {
        if (!($date instanceof \DateTime)) {
            $result = preg_match('/(\d\d\d\d)-(\d\d)-(\d\d)/', $date, $matches);
            if (!$result) {
                throw new ClientErrorException('notFound', 'Invalid Date Format', []);
            }
            $date = (\DateTimeHelper::now())->setDate($matches[1], $matches[2], $matches[3]);
        }

        if ($startTime instanceof \DateTime) {
            $startTime = $startTime->format('U');
        }

        $existingTasks = $this->taskRepository->allByFilter([
            'unit_id'     => $unit->id,
            'date'        => $date,
            'index'       => $index,
            'finished_at' => 0,
        ]);
        if (count($existingTasks) > 0) {
            return $existingTasks[0];
        }

        $taskTemplate = $this->taskTemplateRepository->find($taskTemplateId);
        if (empty($taskTemplate) || $taskTemplate->project_id != $unit->site->project_id) {
            throw new ClientErrorException('notFound', $taskTemplate->project_id.$unit->site->project_id.'Task Template not found');
        }

        if ($taskTemplate->is_exclusive) {
            $taskTemplates = $this->taskTemplateRepository->allByFilter([
                'project_id'    => $taskTemplate->project_id,
                'category_type' => $taskTemplate->category_type,
            ], 'id', 'asc');
            $exclusiveIds  = $taskTemplates->pluck('id')->toArray();
            if (count($exclusiveIds) > 0) {
                $tasks = $this->taskRepository->allByFilter([
                    'task_template_id' => $exclusiveIds,
                    'finished_at'      => 0,
                ], 'id', 'asc');
                foreach ($tasks as $task) {
                    $this->finishTask($task, $startTime - 1);
                }
            }
        }

        return $this->taskRepository->create([
            'unit_id'          => $unit->id,
            'date'             => $date,
            'index'            => $index,
            'task_template_id' => $taskTemplateId,
            'started_at'       => $startTime,
        ]);
    }

    public function finishTask($task, $endTime)
    {
        if ($endTime instanceof \DateTime) {
            $endTime = $endTime->format('U');
        }

        $task = $this->taskRepository->update($task, [
            'finished_at' => $endTime,
        ]);

        return $task;
    }

    public function getTaskForMonth($unit, $year, $month)
    {
        $tasks = $this->taskRepository->allTaskByMonth($unit->id, $year, $month);

        $currentTask  = [];
        $finishedTask = [];
        $project      = $unit->site->project;
        /* @var \App\Models\Task $task */
        foreach ($tasks as $task) {
            $thread         = $this->timelineService->getThread($project, Task::getTableName(), $task->id);
            $task->timeline = [];
            if (!empty($thread)) {
                $filter = [
                    'post_thread_id' => $thread->id,
                ];

                $task->timeline = $this->postRepository->allByFilter($filter, 'posted_at', 'desc');
            }
            if ($task->finished_at === 0) {
                $currentTask[$task->task_template_id][] = $task;
            } else {
                $finishedTask[$task->task_template_id][] = $task;
            }
        }

        $taskTemplates = $this->taskTemplateRepository->allByFilter([
            'project_id'  => $project->id,
            'is_disabled' => false,
        ], 'hierarchy', 'asc');

        $result = [
            'taskTemplates' => $taskTemplates,
            'currentTask'   => $currentTask,
            'finishedTask'  => $finishedTask,
        ];

        return $result;
    }

    /**
     * get task template by day and index.
     *
     * @param $unit
     * @param $day
     * @param $index
     *
     * @return array
     */
    public function getTaskForDay($unit, $day, $index)
    {
        $tasks = $this->taskRepository->allByFilter([
            'unit_id'     => $unit->id,
            'date'        => $day,
            'index'       => $index,
        ], 'id', 'asc');
        $project        = $unit->site->project;
        $currentTask    = [];
        $finishedTask   = [];
        /* @var \App\Models\Task $task */
        foreach ($tasks as $task) {
            $thread         = $this->timelineService->getThread($project, Task::getTableName(), $task->id);
            $task->timeline = [];
            if (!empty($thread)) {
                $filter = [
                    'post_thread_id' => $thread->id,
                ];

                $task->timeline = $this->postRepository->allByFilter($filter, 'posted_at', 'desc');
            }
            if ($task->finished_at === 0) {
                $currentTask[$task->task_template_id][]     = $task;
            } else {
                $finishedTask[$task->task_template_id][]    = $task;
            }
        }

        $taskTemplates = $this->taskTemplateRepository->allByFilter([
            'project_id'  => $unit->site->project->id,
            'is_disabled' => false,
        ], 'hierarchy', 'asc');

        $result = [
            'taskTemplates' => $taskTemplates,
            'currentTask'   => $currentTask,
            'finishedTask'  => $finishedTask,
        ];

        return $result;
    }
}