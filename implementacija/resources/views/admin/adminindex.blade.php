<?php

/**
 * Administratorska index stranica
 *
 * @author Marko Divjak 0084/2017
 *
 * @version 1.0
 */
?>

@extends('layouts.master')

@section('scripts')
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/admin.js') }}" defer></script>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('title')
Admin Dashboard
@endsection

@section('content')
<div class="container scrollMain">
    @if(session()->has('tournament-exists'))
    <div class="alert alert-danger">
        {{session()->get('tournament-exists')}}
    </div>
    @endif
    @if(session()->has('tournament-created'))
    <div class="alert alert-success">
        {{session()->get('tournament-created')}}
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card tournaments mt-5">
                <div class="card-header" style="padding:20px;">
                    @include('inc.new-tournament')
                </div>

                <div class="card-body scrollable" style="padding-bottom:10px;">
                    @if (count($tournaments) > 0)
                    <table class="table scrollable" width="100%">
                        <thead>
                            <tr width="100%">
                                <th width="20%" style="text-align: center">Tournament Name</th>
                                <th width="20%" style="text-align: center">Number of Registrations</th>
                                <th width="20%" style="text-align: center">End Date</th>
                                <th width="20%">&nbsp;</th>
                                <td width="1%">&nbsp;</td>
                                <th width="20%">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tournaments as $tournament)
                            <tr width="100%">
                                <td width="20%"><a href="{{ route('tournament.show', [$tournament->id]) }}">{{$tournament->name}}</a></td>
                                <td width="20%">{{ $tournament->registrations_count }}</td>
                                <td width="18%">{{$tournament->endDate}}</td>
                                <td width="20%">
                                    <a style="width:100%; white-space:normal;" href="{{ route('admin.registrations', [$tournament->id]) }}" class="float-right btn btn-primary">Check Pending Registrations</a>
                                </td>
                                <td width="1%">&nbsp;</td>
                                <td width="20%">
                                    <input style="width:100%; white-space:normal;" type="button" class="float-left btn btn-danger delete-tournament-button" data-delete-link="{{ route('admin.delete', $tournament) }}" data-toggle="modal" data-target="#avatar-picker" data-tournament="{{ $tournament }}" value="Delete Tournament">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div>
                        {{$tournaments->links()}}
                    </div>
                    @else
                    <div class="p-5" style="min-height: 400px; padding: 100px; font-size:26;">
                        <b style="">Currently there are no tournaments</b>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="avatar-picker" tabindex="-1" role="dialog" aria-labelledby="#avatar-picker-label" style="color:#777;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="avatar-picker-label">Are you sure you want to delete this tournament?</h4>
            </div>
            <div class="modal-footer">
                <table>
                    <td>
                        <tr>
                            <form method="POST" id="delete-tournament-form" action="">
                                @csrf
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </tr>
                        <tr>
                            <button type="submit" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        </tr>
                    </td>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection