<?php
namespace App\Services;

use LaravelRocket\Foundation\Services\BaseServiceInterface;

interface TaskServiceInterface extends BaseServiceInterface
{
    /**
     * @param \App\Models\Unit $unit
     * @param \DateTime        $day
     * @param int              $index
     * @param int              $taskTemplateId
     * @param \DateTime        $startTime
     *
     * @return \App\Models\Task
     */
    public function startTask($unit, $day, $index, $taskTemplateId, $startTime);

    /**
     * @param \App\Models\Task $task
     * @param \DateTime        $endTime
     *
     * @return \App\Models\Task
     */
    public function finishTask($task, $endTime);

    /**
     * @param $unit
     * @param $year
     * @param $month
     * @return \App\Models\Task[]
     */
    public function getTaskForMonth($unit, $year, $month);

    /**
     * get task template by day and index
     * @param $unit
     * @param $day
     * @param $index
     * @return array
     */
    public function getTaskForDay($unit, $day, $index);
}