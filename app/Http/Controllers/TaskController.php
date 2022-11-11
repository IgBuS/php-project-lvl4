<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $pespPerson = User::has('tasksAssignedTo')->pluck('name', 'id');
        $authors = User::has('tasksCreatedBy')->pluck('name', 'id');
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $filter = $request->query('filter');

        $tasks = QueryBuilder::for(Task::class)
        ->allowedFilters([AllowedFilter::exact('status_id'),
                        AllowedFilter::exact('assigned_to_id'),
                        AllowedFilter::exact('created_by_id')])
        ->paginate();

        return view('tasks.index', compact('tasks', 'filter', 'pespPerson', 'taskStatuses', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task();
        $users = User::pluck('name', 'id');
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');
        return view('tasks.create', compact('task', 'users', 'taskStatuses', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:tasks',
            'status_id' => 'required',
            'description' => 'nullable|max:255',
            'assigned_to_id' => 'nullable'
        ];

        $customMessages = [
            'required' => __('flash.create_name_require'),
            'unique' => __('flash.task_create_name_unique')
        ];

        $validated = $request->validate($rules, $customMessages);

        $task = new Task();
        $task->fill($validated);
        try {
            $task->created_by_id = optional(Auth::user())->id;
        } catch (\AuthenticationException $e) {
            flash('User is not authenticated')->error();
            return back()->withInput();
        }
        $task->save();

        $labels = collect($request['labels'])
            ->filter(fn($label) => $label !== null);

        $task->labels()->sync($labels);

        flash(__('flash.task_create_success'))->success();
        return redirect()
            ->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $users = User::pluck('name', 'id');
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('tasks.edit', compact('task', 'users', 'taskStatuses', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $rules = [
            'name' => 'required',
            'status_id' => 'required',
            'description' => 'nullable',
            'assigned_to_id' => 'nullable'
        ];

        $customMessages = [
            'required' => __('flash.create_name_require'),
            'unique' => __('flash.task_create_name_unique')
        ];

        $validated = $request->validate($rules, $customMessages);

        $task->fill($validated);

        $labels = collect($request['labels'])
            ->filter(fn($label) => $label !== null);

        $task->labels()->sync($labels);

        $task->save();
        flash(__('flash.task_refresh'))->success();
        return redirect()
            ->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        DB::transaction(function () use ($task): void {
            $task->labels()->detach();
            $task->delete();
        }, 3);
        flash(__('flash.task_delete'))->success();
        return redirect()->route('tasks.index');
    }
}
