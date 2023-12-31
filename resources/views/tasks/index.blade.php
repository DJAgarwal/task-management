@extends('layout')
@section('title', 'Index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0">Tasks List</h5>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Task</a>
                    </div>
                </div>
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="GET" action="{{ route('tasks.index') }}" class="form-inline">
                                    <div class="form-group col-md-6" style="float:left">
                                        <label for="project_id">Select a Project:</label>
                                        <select class="form-control" id="project_id" name="project_id">
                                            <option value="">All Projects</option>
                                            @foreach($projects as $project)
                                            <option value="{{ $project->id }}" @if($selectedProjectId == $project->id) selected @endif>
                                            {{ $project->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6" style="float:right">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 20px;margin-left: 10px;">Search</button>
                                    </div>  
                                </form>
                            </div>
                        </div>
                    <div class="table-responsive" style="margin-top:10px;">
                        <table id="task-table" class="table table-bordered table-striped" data-reorder-url="{{ route('tasks.reorder') }}">
                            <thead>
                                <tr>
                                    <th>Drag</th>
                                    <th>ID</th>
                                    <th>Project</th> 
                                    <th>Name</th>
                                    <th>Priority</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($tasks as $task)
                                <tr data-task-id="{{ $task->id }}">
                                    <td class="drag-handle"><i class="fas fa-grip-vertical"></i></td>
                                    <td>{{ $task->id }}</td>
                                    <td>
                                        @if($task->project)
                                        {{ $task->project->name }}
                                        @else
                                        No Project
                                        @endif
                                    </td>
                                    <td>{{ $task->name }}</td>
                                    <td>#{{ $task->priority }}</td>
                                    <td>{{ date('M d, Y H:i:s', strtotime($task->created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection