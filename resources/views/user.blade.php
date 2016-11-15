@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="center-div">
            <img width="196" class="img-circle img-responsive center-block" src="{{$user->uud_avatar_url}}"
                 onerror="this.src='{{$user->avatar_url}}'">
            <h2>{{$user->name}}</h2>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading center-div">
                <h3 class="panel-title">Information and Contact</h3>
            </div>
            <div class="panel-body">
                <div class="col-md-12 well">
                    <div class="col-md-4">
                        <h4><b><u>User Info:</u></b></h4>
                        @if(!empty($user->uud_name_first))<p><b>First Name:</b> {{$user->uud_name_first}}</p>@endif
                        @if(!empty($user->uud_name_last))<p><b>Last Name:</b> {{$user->uud_name_last}}</p>@endif
                        <p><b>ID Number:</b> {{$user->uud_identifier}}</p>
                        <p><b>Username:</b> {{$user->uud_username}}</p>
                    </div>
                    <div class="col-md-4">
                        <h4><b><u>User Emails:</u></b></h4>
                        @if(!empty($user->emails))
                            @foreach($user->emails as $email)
                                <p>{{$email->email}}</p>
                            @endforeach
                        @else
                            <p>User has no emails.</p>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <h4><b><u>User Phones:</u></b></h4>
                        @if(!empty($user->phones))
                            @foreach($user->phones as $phone)
                                <p>{{$phone->number_formatted}}</p>
                            @endforeach
                        @else
                            <p>User has no phones</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @permission('manage-vehicles', 'manage-permits', 'view-purchases')
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-pills nav-justified">
                    @permission('manage-vehicles')

                    @if($chose_active)
                        <li role="presentation">
                    @else
                        <?php $chose_active = true;  ?>
                        <li role="presentation" class="active">
                            @endif
                            <a data-toggle="tab" href="#vehicles">
                                <h3 class="panel-title">
                                    <i class="fa fa-car"></i> Vehicles
                                </h3>
                            </a>
                        </li>
                        @endpermission
                        @permission('manage-permits')
                        @if($chose_active)
                            <li role="presentation">
                        @else
                            <?php $chose_active = true;  ?>
                            <li role="presentation" class="active">
                                @endif
                                <a data-toggle="tab" href="#permits">
                                    <h3 class="panel-title">
                                        <i class="fa fa-check-square"></i> Permits
                                    </h3>
                                </a>
                            </li>
                            @endpermission
                            @permission('view-purchases')
                            @if($chose_active)
                                <li role="presentation">
                            @else
                                <?php $chose_active = true;  ?>
                                <li role="presentation" class="active">
                                    @endif
                                    <a data-toggle="tab" href="#purchases">
                                        <h3 class="panel-title">
                                            <i class="fa fa-dollar"></i> Purchases
                                        </h3>
                                    </a>
                                </li>
                                @endpermission
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <?php $chose_active = false;  ?>
                    @permission('manage-vehicles')
                    <div class="tab-pane @if(!$chose_active) <?php $chose_active = true;?> active @endif" id="vehicles">
                        <div class="col-md-4">
                            @if(0 < count($user->vehicles))
                                @foreach($user->vehicles as $vehicle)
                                    <a href="/manage/vehicles/{{$vehicle->id}}">
                                        <p>{{$vehicle->year}} {{$vehicle->vehicle_make->name}} {{$vehicle->vehicle_model->name}}</p>
                                    </a>
                                @endforeach
                            @else
                                <p>User has no vehicles</p>
                            @endif
                        </div>
                    </div>
                    @endpermission

                    @permission('manage-permits')
                    <div class="tab-pane @if(!$chose_active) <?php $chose_active = true;?> active @endif" id="permits">
                        @if(0 < count($user->permits))
                            @foreach($user->permits as $permit)
                                <a href="/manage/permits/{{$permit->id}}">
                                    <p>{{$permit->permit_code}} - {{$permit->plan->name}}</p>
                                </a>
                            @endforeach
                        @else
                            <p>User has no permits</p>
                        @endif
                    </div>
                    @endpermission

                    @permission('view-purchases')
                    <div class="tab-pane @if(!$chose_active) <?php $chose_active = true;?> active @endif"
                         id="purchases">
                        @if(0 < count($user->purchases))
                            @foreach($user->purchases as $purchase)
                                <p>{{$purchase->created_at->format('D, M d, Y \a\t g:i A')}} -
                                    ${{$purchase->plan->price}} @if($purchase->payed) payed. @else owed. @endif</p>
                            @endforeach
                        @else
                            <p>User has no purchases</p>
                        @endif
                    </div>
                    @endpermission

                </div>
            </div>
        </div>
        @endpermission
        @permission('manage-roles')

        <div class="panel panel-default">
            <div class="panel-heading center-div">
                <h3 class="panel-title">Application Role</h3>
            </div>
            <div class="panel-body container-fluid">

                @if($user->id == Auth::user()->id)
                    <div class="col-md-12">
                        <div class="well">
                            @foreach($roles as $role)
                                @if($role->id == $user->role->id)
                                    <div class="center-div">
                                        <h3>Your Role: {{$role->display_name}}</h3>
                                    </div>
                                    <p><b>Description: </b>
                                    <div id="role_description">{{$role->description}}</div>
                                    <p><b>Permissions: </b>
                                    <ul>
                                        @foreach($role->permissions as $permission)
                                            <li>
                                                You {{strtolower($permission->description)}}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @elseif(!$can_manage_role)
                    <div class="col-md-12">
                        <div class="well">
                            @foreach($roles as $role)
                                @if($role->id == $user->role->id)
                                    <div class="center-div">
                                        <h3>Role: {{$role->display_name}}</h3>
                                    </div>
                                    <p><b>Description: </b>
                                    <div id="role_description">{{$role->description}}</div>
                                    <p><b>Permissions: </b>
                                    <ul>
                                        @foreach($role->permissions as $permission)
                                            <li>
                                                {{($permission->description)}}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else

                    {!! Form::open([
                            'url' => '/manage/users/'. $user->id .'/role',
                            'name' => 'user_role_form',
                            'id' => 'user_role_form',
                            'data-toggle'=>'validator',
                            'role' => 'form',
                            'method' => 'post'
                            ]) !!}

                    <input id="current_role" name="current_role" type="text" style="display: none;"
                           value="{{$user->role->id}}">
                    <input id="current_user" name="current_user" type="text" style="display: none;"
                           value="{{$user->id}}" readonly="readonly">

                    <div class="col-md-12">
                        <div class="well">
                            <div class="form-group">
                                <div class="center-div col-md-8" style="margin-bottom: 10px;">
                                    <select id="role" name="role" class="form-control" required>
                                        @foreach($roles as $role)
                                            @if($role->id == $user->role->id)
                                                <option value="{{$role->id}}" selected>{{$role->display_name}}</option>
                                            @else
                                                <option value="{{$role->id}}">{{$role->display_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i>  Save', ['type' => 'submit', 'class' => 'btn btn-success btn-block', 'id' => 'submitBtn','style' => 'margin-bottom: 10px;']) !!}
                                </div>
                            </div>
                            <br/>
                            <div id="role_info" class="form-group">
                                @foreach($roles as $role)
                                    @if($role->id == $user->role->id)
                                        <div id="role-{{$role->id}}">
                                            @else
                                                <div id="role-{{$role->id}}" style="display: none;">
                                                    @endif
                                                    <p><b>Description: </b>
                                                    <div id="role_description">{{$role->description}}</div>
                                                    </p>
                                                    @if(count($role->permissions) > 0)
                                                        <p><b>Permissions: </b></p>
                                                        <ul id="permission_list">
                                                            @foreach($role->permissions as $permission)
                                                                <li>
                                                                    {{$permission->description}}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p><b>Permissions: </b> This role has no permissions.</p>
                                                    @endif
                                                </div>
                                                @endforeach
                                        </div>
                            </div>
                        </div>

                        {!! Form::close() !!}
                        @endif
                    </div>
            </div>
            @endpermission
        </div>


        @endsection

        @section('page_foot')
            <p class="navbar-text col-md-12 col-sm-12 col-xs-12">

            </p>
        @endsection

        @section('foot')
            <script type="text/javascript">
                $('#role').select2({
                    placeholder: "Select this user's role",
                    dataType: 'json',
                    theme: 'bootstrap',
                    allowClear: true,
                    minimumSelectionSize: 1
                }).on("select2:select", function (e) {
                    var object = e.params.data;
                    var oldObjectId = $("#current_role").val();
                    $("#role-" + oldObjectId).hide();
                    $("#role-" + object.id).show();
                    $("#current_role").val(object.id);
                });
            </script>
@endsection