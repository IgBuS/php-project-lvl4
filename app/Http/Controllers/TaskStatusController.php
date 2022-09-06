<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;

class TaskStatusController extends Controller
{
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
        $status = new TaskStatus();
        return view('statuses.create', compact('status'));
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
            'name' => 'unique:task_statuses'
        ]);
        $status = new TaskStatus();
        $status->fill($validated);
        $status->save();

        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::check()) {
            $status = TaskStatus::findOrFail($id);
            return view('statuses.edit', compact('status'));
        }
        abort(401);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if (Auth::check()) {
            $validated = $request->validate([
                'name' => 'unique:task_statuses'
            ]);
            $status = TaskStatus::findOrFail($id);
            $status->fill($validated);
            $status->save();
            flash('Статус успешно обновлен')->success();
            return redirect()
                ->route('task_statuses.index');
        }
        abort(401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::check()) {
            TaskStatus::findOrFail($id)->delete();
            flash('Статус успешно удален')->success();
            return redirect()->route('task_statuses.index');
        }

        flash('Не удалось удалить статус')->error();
        return redirect()->route('task_statuses.index');
    }
}
