<?php
namespace App\Services;

use DateTime;
use App\Models\Activity;

trait Utils
{

    public function logToActivity($userId, $targetId, $targetClass, $action)
    {
        Activity::create([
            'user_id' => $userId,
            'target_id' => $targetId,
            'target_class' => $targetClass,
            'action_type' => $action,
        ]);
    }

    public function getActivity()
    {
        $data = Activity::orderBy('created_at', 'DESC')->where('user_id', auth()->user()->id)->get();
        $acts = $data->map(function ($act) {
            return $this->format($act);
        });

        return $acts;
    }

    public function format($activity)
    {
        $active_user = \App\Models\User::findOrFail($activity->user_id);
        $class = $activity->target_class;
        $object = collect([]);
        $className = '';

        try {
            switch ($class) {
                case \App\Models\Course::class :
                    $object = \App\Models\Course::findOrFail($activity->target_id);
                    $className = 'course';
                    break;
                case \App\Models\Subject::class :
                    $object = \App\Models\Subject::findOrFail($activity->target_id);
                    $className = 'subject';
                    break;
                case \App\Models\Task::class :
                    $object = \App\Models\Task::findOrFail($activity->target_id);
                    $className = 'task';
                    break;
                case \App\Models\User::class :
                    $object = \App\Models\User::findOrFail($activity->target_id);
                    $className = 'user';
                    break;
                case \App\Models\UserSubject::class :
                    $object = \App\Models\UserSubject::findOrFail($activity->target_id);
                    $className = 'user_subjects';
                    break;
            }
        } catch (Exception $e) {
            throw new Exception('error when gets instance from target_class cause : ' . $e->getMessage());
        }

        $act = app()->make('stdClass');

        if (isset($active_user)) {
            $act->avatar = $active_user->avatar;
        }

        $data = [
            'active_user_name' => $active_user->name,
            'active_user_avatar' => $active_user->avatar,
            'className' => $className,
            'objectName' => $object->name,
            'target_id' => $activity->target_id,
            'action' => $this->generateAction($activity->action_type),
            'time' => $this->getDiffTime($activity->created_at),
            'link-to-object-detail' => $this->get_links($object, $className),
        ];

        return json_encode($data);
    }

    public function get_links($object, $name)
    {
        if ($name == 'course') {
            return route('admin.courses.show', ['course' => $object->id]);
        } else if ($name == 'subject') {
            return route('admin.subject.show', ['subject' => $object->id]);
        } else if ($name == 'task') {
            return route('admin.task.show', ['course' => $object->id]);
        } else if ($name == 'user') {
            return route('admin.user.show', ['course' => $object->id]);
        }
    }

    public function calculate_time_span($date)
    {
        $seconds = strtotime(date('Y-m-d H:i:s')) - strtotime($date);
        $months = floor($seconds / (3600 * 24 * 30));
        $day = floor($seconds / (3600 * 24));
        $hours = floor($seconds / 3600);
        $mins = floor(($seconds - ($hours * 3600)) / 60);
        $secs = floor($seconds % 60);

        if ($seconds < 60)
            $time = $secs . " seconds ago";
        else if ($seconds < 60 * 60)
            $time = $mins . " min ago";
        else if ($seconds < 24 * 60 * 60)
            $time = $hours . " hours ago";
        else if ($seconds < 24 * 60 * 60)
            $time = $day . " day ago";
        else
            $time = $months . " month ago";

        return $time;
    }

    public function getDiffTime($time)
    {
        if (!isset($time) || $time == null)
            return;

        return $this->calculate_time_span($time);
    }

    public function generateAction($action)
    {
        switch ($action) {
            case config('common.action_type.create') :
                return 'created';
            case config('common.action_type.update') :
                return 'updated';
            case config('common.action_type.delete') :
                return 'deleted';
            case config('common.action_type.join') :
                return 'joined';
            case config('common.action_type.finish') :
                return 'finished';
            case config('common.action_type.start') :
                return 'started';
        }
    }
}