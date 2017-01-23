@extends('frontend.layouts.app')

@section('content')

    <input type="hidden" readonly="readonly" id="api_requests_count_total" name="api_requests_count_total"
           value="{{$apiQueries}}">

    <div class="row">

        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('navs.frontend.dashboard') }}</div>

                <div class="panel-body">

                    <div class="row">

                        <div class="col-md-4 col-md-push-8">

                            <ul class="media-list">
                                <li class="media">
                                    <div class="media-left">
                                        <img class="media-object" width="80px" src="{{ $logged_in_user->picture }}"
                                             alt="Profile picture">
                                    </div><!--media-left-->

                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            {{ $logged_in_user->name }}<br/>
                                            <small>
                                                {{ $logged_in_user->email }}<br/>
                                                Joined {{ $logged_in_user->created_at->format('F jS, Y') }}
                                            </small>
                                        </h4>

                                        {{ link_to_route('frontend.user.account', trans('navs.frontend.user.account'), [], ['class' => 'btn btn-info btn-xs']) }}

                                        @permission('view-backend')
                                        {{ link_to_route('admin.dashboard', trans('navs.frontend.user.administration'), [], ['class' => 'btn btn-danger btn-xs']) }}
                                        @endauth
                                    </div><!--media-body-->
                                </li><!--media-->
                            </ul><!--media-list-->

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>Your API Requests</h4>
                                </div><!--panel-heading-->
                                <div class="panel-body">
                                    <h2 class="center-div" id="api_requests_count" name="api_requests_count">{{$apiQueries}}</h2>
                                </div><!--panel-body-->
                            </div><!--panel-->

                        </div><!--col-md-4-->

                        <div class="col-md-8 col-md-pull-4">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4>API Secret</h4>
                                        </div><!--panel-heading-->
                                        <div class="panel-body">
                                            <p>This is your API Secret. Keep it safe and treat it like a password!</p>
                                            <div class="form-group">
                                                <div class="col-md-10">
                                                    <input id="secret" class="form-control" type="password"
                                                           data-toggle="password" readonly="readonly"
                                                           value="{{$secret}}">
                                                </div>
                                                <a href="/secret/refresh" class="btn btn-danger">New Secret
                                                </a>
                                            </div>
                                        </div><!--panel-body-->
                                    </div><!--panel-->
                                </div><!--col-xs-12-->
                            </div><!--row-->

                            <div class="row">
                                @permission('read-account')
                                <input type="hidden" readonly="readonly" id="account_count_total"
                                       name="account_count_total"
                                       value="{{$accountCount}}">
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4>API Accounts</h4>
                                        </div><!--panel-heading-->
                                        <div class="panel-body">
                                            <h2 class="center-div" id="account_count" name="account_count">0</h2>
                                        </div><!--panel-body-->
                                    </div><!--panel-->
                                </div><!--col-md-6-->
                                @endauth
                                @permission('read-course')
                                <input type="hidden" readonly="readonly" id="course_count_total"
                                       name="course_count_total"
                                       value="{{$courseCount}}">
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4>Course Count</h4>
                                        </div><!--panel-heading-->
                                        <div class="panel-body">
                                            <h2 class="center-div" id="course_count" name="course_count">0</h2>
                                        </div><!--panel-body-->
                                    </div><!--panel-->
                                </div><!--col-md-6-->
                                @endauth
                                @permission('read-email')
                                <input type="hidden" readonly="readonly" id="email_count_total" name="email_count_total"
                                       value="{{$emailCount}}">
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4>Email Count</h4>
                                        </div><!--panel-heading-->
                                        <div class="panel-body">
                                            <h2 class="center-div" id="email_count" name="email_count">0</h2>
                                        </div><!--panel-body-->
                                    </div><!--panel-->
                                </div><!--col-md-6-->
                                @endauth
                                @permission('read-mobile-phone')
                                <input type="hidden" readonly="readonly" id="mobile_phone_count_total"
                                       name="mobile_phone_count_total"
                                       value="{{$mobilePhoneCount}}">
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4>Mobile Phone Count</h4>
                                        </div><!--panel-heading-->
                                        <div class="panel-body">
                                            <h2 class="center-div" id="mobile_phone_count" name="mobile_phone_count">
                                                0</h2>
                                        </div><!--panel-body-->
                                    </div><!--panel-->
                                </div><!--col-md-6-->
                                @endauth

                            </div><!--row-->

                        </div><!--col-md-8-->

                    </div><!--row-->

                </div><!--panel body-->

            </div><!-- panel -->

        </div><!-- col-md-10 -->

    </div><!-- row -->

@endsection

@section('scripts')
    <script type="text/javascript">
        var api_requests = $('#api_requests_count_total').val();
        var account_count = $('#account_count_total').val();
        var course_count = $('#course_count_total').val();
        var email_count = $('#email_count_total').val();
        var mobile_phone_count = $('#mobile_phone_count_total').val();

        if (api_requests) {
            $('#api_requests').animateNumber({number: api_requests_count});
        }
        if (account_count) {
            $('#account_count').animateNumber({number: account_count});
        }
        if (course_count) {
            $('#course_count').animateNumber({number: course_count});
        }
        if (email_count) {
            $('#email_count').animateNumber({number: email_count});
        }
        if (mobile_phone_count) {
            $('#mobile_phone_count').animateNumber({number: mobile_phone_count});
        }
    </script>
@endsection

