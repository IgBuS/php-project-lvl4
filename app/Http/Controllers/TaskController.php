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
        $pespPersona = User::has('tasksAssignedTo')->orderBy('name', 'asc')->get();
        $authors = User::has('tasksCreatedBy')->orderBy('name', 'asc')->get();
        $rawTaskStatuses = TaskStatus::orderBy('name', 'asc')->get();

        $tasks = QueryBuilder::for(Task::class)
        ->allowedFilters([AllowedFilter::exact('status_id'),
                        AllowedFilter::exact('assigned_to_id'),
                        AllowedFilter::exact('created_by_id')])
        ->paginate();

        $data = [
            'tasks' => $tasks,
            'pespPersona' => $pespPersona,
            'taskStatuses' => $rawTaskStatuses,
            'authors' => $authors
        ];

        //$tasks = Task::orderBy('id', 'asc')->paginate();
        return view('tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task();
        $rawUsers = User::orderBy('name', 'asc')->get();
        $rawTaskStatuses = TaskStatus::orderBy('name', 'asc')->get();
        $labels = Label::orderBy('name', 'asc')->get();
        $data = [
            'task' => $task,
            'users' => $rawUsers,
            'taskStatuses' => $rawTaskStatuses,
            'labels' => $labels
        ];
        return view('tasks.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'status_id' => 'required',
            'description' => 'nullable',
            'assigned_to_id' => 'nullable'
        ]);
        $task = new Task();
        $task->fill($validated);
        $task->created_by_id = Auth::user()->id;
        $task->save();
        $task->labels()->sync($request['labels']);

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
        $rawUsers = User::orderBy('name', 'asc')->get();
        $rawTaskStatuses = TaskStatus::orderBy('name', 'asc')->get();
        $labels = Label::orderBy('name', 'asc')->get();

        $data = [
            'task' => $task,
            'users' => $rawUsers,
            'taskStatuses' => $rawTaskStatuses,
            'labels' => $labels
        ];
        return view('tasks.edit', $data);
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
        $validated = $request->validate([
            'name' => 'required',
            'status_id' => 'required',
            'description' => 'nullable',
            'assigned_to_id' => 'nullable'
        ]);
        $task->fill($validated);
        $task->labels()->sync($request['labels']);
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
        $task->delete();
        flash('Статус успешно удален')->success();
        return redirect()->route('tasks.index');
    }
}
