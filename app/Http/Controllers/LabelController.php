<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Label::class, 'label');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Label::orderBy('id', 'asc')->paginate();
        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $label = new Label();
        return view('labels.create', compact('label'));
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
            'name' => 'required|unique:labels',
            'description' => 'nullable|max:500'
        ];

        $customMessages = [
            'required' => __('flash.create_name_require'),
            'unique' => __('flash.label_create_name_unique')
        ];

        $validated = $request->validate($rules, $customMessages);

        $label = new Label();
        $label->fill($validated);
        $label->save();
        flash(__('flash.label_create_success'))->success();
        return redirect()
            ->route('labels.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        return redirect()->route('labels.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        $rules = [
            'name' => 'required',
            'description' => 'nullable|max:500'
        ];

        $customMessages = [
            'required' => __('flash.create_name_require'),
            'unique' => __('flash.label_create_name_unique')
        ];

        $validated = $request->validate($rules, $customMessages);

        $label->fill($validated);
        $label->save();
        flash(__('flash.label_refresh'))->success();
        return redirect()
            ->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        if ($label->tasks()->count() === 0) {
            $label->delete();
            flash(__('flash.label_delete_success'))->success();
            return redirect()->route('labels.index');
        }
        flash(__('flash.label_delete_error'))->error();
        return redirect()->route('labels.index');
    }
}
