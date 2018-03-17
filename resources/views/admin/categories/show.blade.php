@extends('admin.layouts.admin')

@section('title', $category->title)

@section('content')
    <div class="row">
        <table class="table table-striped table-hover">
            <tbody>
            <tr>
                <th>Title</th>
                <td>{{ $category->title }}</td>
            </tr>

            <tr>
                <th>Icon Url</th>
                <td>{{ $category->icon_url  }}</td>
            </tr>

            <tr>
                <th>Created At</th>
                <td>{{ $category->created_at }} ({{ $category->created_at->diffForHumans() }})</td>
            </tr>

            <tr>
                <th>Updated At</th>
                <td>{{ $category->updated_at }} ({{ $category->updated_at->diffForHumans() }})</td>
            </tr>
            </tbody>
        </table>
    </div>
    <a class="btn btn-primary" href="{{ URL::previous() }}">Back</a>
@endsection