@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Settings</small>
    </h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Settings</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/settings') }}">
                {!! csrf_field() !!}

                <div class="form-group">
                    <div class="center-div form-group">
                        <h3>General</h3>
                        <p>general settings</p>
                    </div>

                    <div class="form-group{{ $errors->has('email_blacklist') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Banned Email Domains</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="email_blacklist"
                                   value="{{ $email_blacklist }}"
                                   placeholder="example.com, example.tld (Comma Separated)">

                            @if ($errors->has('email_blacklist'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email_blacklist') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="center-div form-group">
                        <h3>Security</h3>
                        <p>security settings</p>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Allow Public Registration</label>
                        <div class="col-md-6">
                            <div class="material-switch pull-left">
                                <input type="checkbox" id="allow_reg" name="allow_reg"
                                       value="{{$allow_reg}}" {{$checked_allow_reg}}>
                                <label for="allow_reg" class="label-primary"></label>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-floppy-o"></i>Save Settings
                        </button>
                    </div>
                </div>
            </form>

        </div><!-- /.box-body -->
    </div><!--box box-success-->
@endsection