@extends('admin.layouts.admin')

@section('title','Reports')

@section('content')
    <div class="row">
        <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>Post</th>
                <th>Reported By</th>
                <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $report)
                <tr>
                    <td><a href="{{ route('admin.posts.show', [$report->post_id]  ) }}">{{ $report->post_id }}</a></td>
                    <td><a href="{{ route('admin.profiles.show', [$report->user_profile_id]  ) }}">{{ $report->user_profile_id }}</a></td>
                    <td>{{ $report->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $reports->links() }}
        </div>
    </div>
@endsection