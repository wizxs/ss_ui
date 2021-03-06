@extends('layout')

@section('content')
    <div class="wrapper wrapper-content" style="padding-top: 2px;" ng-controller="SingleGroupFilesController">
        <div class="row animated fadeInRight">
            <div class="col-md-1">
                @include('ss.groups.partials._menu_nav')
            </div>
            <div class="col-md-11">
                <div class="row col-md-12">
                    <div class="ibox float-e-margins single-group-title">
                        <div class="ibox-title activity-group-title"
                             data-toggle="tooltip"
                             data-placement="bottom"
                             title="Compiled activities from all your groups.">
                            <h5 style="text-align: center">{{ $group->name }}'s Files</h5>
                            <span class="pull-right">
                                <a href="#">
                                    <img src="{{ asset($group->profilePictureSource()) }}"
                                            alt="Group class second 2013's picture"
                                            class="activity-group-pic">
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                @include('ss.groups.partials._files_nav')
                @include('ss.groups.partials._files_list')
            </div>
            @include('partials._delete_file_modal')
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.file-box').each(function() {
                animationHover(this, 'pulse');
            });
        });
    </script>
@endsection

@section('jquery_scripts')
    <script src="{{ asset('/js/backpack.js') }}"></script>
@endsection