<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class, 'task_status');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskStatuses = TaskStatus::orderBy('id', 'asc')->paginate();
        return view('statuses.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taskStatus = new TaskStatus();
        return view('statuses.create', compact('taskStatus'));
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
            'name' => 'required|unique:task_statuses',
        ];
    
        $customMessages = [
            'required' => __('flash.status_create_name_require'),
            'unique' => __('flash.status_create_name_unique')
        ];

        $validated = $request->validate($rules, $customMessages);
        $status = new TaskStatus();
        $status->fill($validated);
        $status->save();
        flash(__('flash.status_create_success'))->success();
        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function show(TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskStatus $taskStatus)
    {
        return view('statuses.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $rules = [
            'name' => 'required|unique:task_statuses',
        ];
    
        $customMessages = [
            'required' => __('flash.create_name_require'),
            'unique' => __('flash.status_create_name_unique')
        ];

        $validated = $request->validate($rules, $customMessages);

        $taskStatus->fill($validated);
        $taskStatus->save();
        flash(__('flash.status_refresh'))->success();
        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->count() === 0) {
            $taskStatus->delete();
            flash(__('flash.status_delete_success'))->success();
            return redirect()->route('task_statuses.index');
        }
        flash(__('flash.status_delete_error'))->error();
        return redirect()->route('task_statuses.index');
    }
}
