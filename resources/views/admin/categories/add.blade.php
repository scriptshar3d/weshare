@extends('admin.layouts.admin')

@section('title', 'Add Category')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            {{ Form::open(['route'=>['admin.categories.store'],'method' => 'post', 'enctype' => 'multipart/form-data',
            'class'=>'form-horizontal form-label-left' ]) }}

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                    Title
                    <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="title" type="text"
                           class="form-control col-md-7 col-xs-12 @if($errors->has('title')) parsley-error @endif"
                           name="title" value="" required>
                    @if($errors->has('title'))
                        <ul class="parsley-errors-list filled">
                            @foreach($errors->get('title') as $error)
                                <li class="parsley-required">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icon">
                    Icon
                    <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="icon" type="file"
                           class="form-control col-md-7 col-xs-12 @if($errors->has('icon')) parsley-error @endif"
                           name="icon" value="" required>
                    @if($errors->has('icon'))
                        <ul class="parsley-errors-list filled">
                            @foreach($errors->get('icon') as $error)
                                <li class="parsley-required">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a class="btn btn-primary" href="{{ URL::previous() }}">Cancel</a>
                    <button type="submit" class="btn btn-success"> Save</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/users/edit.css')) }}
@endsection

@section('scripts')
    @parent
    {{ Html::script(mix('assets/admin/js/users/edit.js')) }}
@endsection