@extends('admin.layouts.admin')

@section('title','Categories')

@section('content')
    <div class="row">
        <div class="row">
            <div class="col-sm-4 pull-right">
                {{ Form::open(['route'=>['admin.categories'],'method' => 'get']) }}
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search Category" name="search"
                           value="{{ app('request')->input('search') }}">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                      </span>
                </div>
                {{ Form::close() }}
            </div>
            <div class="col-sm-4">
                <a class="btn btn-primary" href="{{ route('admin.categories.create') }}">Add Category</a>
            </div>
        </div>
        <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>@sortablelink('name', 'Title', ['page' => $categories->currentPage()])</th>
                <th>Icon</th>
                <th>Created At</th>
                <th>Update At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->title }}</td>
                    <td><a target="_blank" href="{{ $category->icon_url }}">{{ $category->icon_url }}</a></td>
                    <td>{{ $category->created_at }}</td>
                    <td>{{ $category->updated_at }}</td>
                    <td>
                        <a class="btn btn-xs btn-primary" href="{{ route('admin.categories.show', [$category->id]) }}"
                           data-toggle="tooltip" data-placement="top" data-title="View">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-xs btn-info" href="{{ route('admin.categories.edit', [$category->id]) }}"
                           data-toggle="tooltip" data-placement="top" data-title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a class="btn btn-xs btn-danger" href="{{ route('admin.categories.destroy', [$category->id]) }}"
                           data-toggle="tooltip" data-placement="top" data-title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $categories->links() }}
        </div>
    </div>
@endsection