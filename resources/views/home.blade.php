@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Account Roles and Permissions</div>
                    <div class="panel-body">
                        @foreach($roles as $role)
                            <h5>{{$role->display_name}} - <sub>{{$role->description}}</sub>:</h5>
                            <ul>
                                @foreach($role->perms as $perm)
                                    <li>
                                        <h6>{{$perm->display_name}} - <sub>{{$perm->description}}</sub></h6>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
