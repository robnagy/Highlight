@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">DEMO</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>This is Highlight, a simple task management system. You can add tasks, subtasks, and tags, using a simple VueJS based UI, with realtime updates to a backend database.</p>
                    <div><img src="img/screenshot_tasks.png" alt="Screenshot of the tasks interface"></div>

                    <p>It's easy to add subtasks and tags to any task, and they can be selected and marked as complete as well:</p>
                    <div> <img src="img/screenshot_subtasks.png" alt="Screenshot of the subtasks interface"> </div>

                    <p><a href="{{ route('register') }}">Register</a> to get started, or try a <a href="{{ route('auth.guestLogin') }}">guest account</a> (this is reset regularly).
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
