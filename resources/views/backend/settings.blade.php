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

                            <div class="text-center">
                                <p>Email domains that are not allowed for external email addresses.</p>
                            </div>

                            @if ($errors->has('email_blacklist'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email_blacklist') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('confirmation_from_address') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Confirmation From Address</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="confirmation_from_address"
                                   value="{{ $confirmation_from_address }}"
                                   placeholder="confirmation@domain.tld">

                            <div class="text-center">
                                <p>The email address that users will see when confirming their email.</p>
                            </div>

                            @if ($errors->has('confirmation_from_address'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('confirmation_from_address') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('asset_verification_server_url') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Asset Verification Server URL</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="asset_verification_server_url"
                                   value="{{ $asset_verification_server_url }}"
                                   placeholder="https://verify.domain.com">

                            <div class="text-center">
                                <p>Web address of the ORM Asset Verification Server.</p>
                            </div>

                            @if ($errors->has('asset_verification_server_url'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('asset_verification_server_url') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('logo_url') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Logo URL</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="logo_url"
                                   value="{{ $logo_url }}"
                                   placeholder="https://www.domain.com/img/logo.png">

                            <div class="text-center">
                                <p>Web address of a logo for emails.</p>
                            </div>

                            @if ($errors->has('logo_url'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('logo_url') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Broadcast Events</label>
                        <div class="col-md-6">
                            <div class="material-switch pull-left">
                                <input type="checkbox" id="bc_events" name="bc_events"
                                       value="{{$bc_events}}" {{$bc_events_checked}}>
                                <label for="bc_events" class="label-primary"></label>
                            </div>
                            <div class="text-center">
                                <p>Required for LDAP and other 3rd party delegates.</p>
                            </div>
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
                    <div class="center-div form-group">
                        <h3>LDAP Settings</h3>
                        <p>LDAP settings, specifically Active Directory</p>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Enable LDAP</label>
                        <div class="col-md-6">
                            <div class="material-switch pull-left">
                                <input type="checkbox" id="ldap_enabled" name="ldap_enabled"
                                       value="{{$ldap_enabled}}" {{$checked_enable_ldap}}>
                                <label for="ldap_enabled" class="label-primary"></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Primary Duty Maps to OU</label>
                        <div class="col-md-6">
                            <div class="material-switch pull-left">
                                <input type="checkbox" id="ldap_duties_map_to_ou" name="ldap_duties_map_to_ou"
                                       value="{{$ldap_duties_map_to_ou}}" {{$checked_duties_map_to_ou}}>
                                <label for="ldap_duties_map_to_ou" class="label-primary"></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Delete accounts</label>
                        <div class="col-md-6">
                            <div class="material-switch pull-left">
                                <input type="checkbox" id="ldap_delete_users" name="ldap_delete_users"
                                       value="{{$ldap_delete_users}}" {{$checked_delete_users}}>
                                <label for="ldap_delete_users" class="label-primary"></label>
                            </div>
                            <div class="text-center">
                                <p>If turned off, LDAP accounts are disabled upon API deletion.</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('ldap_hosts') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Servers</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="ldap_hosts"
                                   value="{{ $ldap_hosts }}"
                                   placeholder="dc1.example.com, dc2.example.com (Comma Separated)">

                            @if ($errors->has('ldap_hosts'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('ldap_hosts') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('ldap_bind_user') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Bind Username</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="ldap_bind_user"
                                   value="{{ $ldap_bind_user }}"
                                   placeholder="serviceAccount">

                            @if ($errors->has('ldap_bind_user'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('ldap_bind_user') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('ldap_bind_password') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Bind Password</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="ldap_bind_password"
                                   value="{{ $ldap_bind_password }}"
                                   placeholder="StrongPassword">

                            @if ($errors->has('ldap_bind_password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('ldap_bind_password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('ldap_tree_base') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Tree Base</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="ldap_tree_base"
                                   value="{{ $ldap_tree_base }}"
                                   placeholder="DC=DOMAIN,DC=TLD">

                            @if ($errors->has('ldap_tree_base'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('ldap_tree_base') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('ldap_base_user_dn') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Base User OU</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="ldap_base_user_dn"
                                   value="{{ $ldap_base_user_dn }}"
                                   placeholder="OU=Users,DC=DOMAIN,DC=TLD">

                            @if ($errors->has('ldap_base_user_dn'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('ldap_base_user_dn') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('ldap_base_group_dn') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Base Group OU</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="ldap_base_group_dn"
                                   value="{{ $ldap_base_group_dn }}"
                                   placeholder="OU=Groups,DC=DOMAIN,DC=TLD">

                            @if ($errors->has('ldap_base_group_dn'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('ldap_base_group_dn') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('ldap_home_drive_letter') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Home Drive Letter</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="ldap_home_drive_letter"
                                   value="{{ $ldap_home_drive_letter }}"
                                   placeholder="H">

                            @if ($errors->has('ldap_home_drive_letter'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('ldap_home_drive_letter') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('ldap_home_drive_path') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Home Drive Path Pattern</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="ldap_home_drive_path"
                                   value="{{ $ldap_home_drive_path }}"
                                   placeholder="\\fs.domain.tld\homes\%sAMAccountName%">

                            @if ($errors->has('ldap_home_drive_path'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('ldap_home_drive_path') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('ldap_email_domain') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Email Domain</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="ldap_email_domain"
                                   value="{{ $ldap_email_domain }}"
                                   placeholder="domain.tld">

                            @if ($errors->has('ldap_email_domain'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('ldap_email_domain') }}</strong>
                                    </span>
                            @endif
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