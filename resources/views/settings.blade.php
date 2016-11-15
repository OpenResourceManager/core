@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-btn fa-cogs"></i>SLERP API Settings</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/settings') }}">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
