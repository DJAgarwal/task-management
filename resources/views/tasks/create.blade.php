@extends('layout')
@section('title', 'Create Task')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0">Tasks Create</h5>
                        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="project_id">Project</label>
                            <select class="form-control" id="project_id" name="project_id">
                            <option value="">Select a project</option>
                            @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Task Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection