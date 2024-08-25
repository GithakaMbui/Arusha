@extends('admin.layouts.master')

@section('content')

<div class="page-header">
                            <div class="row align-items-end">
                                <div class="col-lg-8">
                                    <div class="page-header-title">
                                        <i class="ik ik-inbox bg-blue"></i>
                                        <div class="d-inline">
                                            <h5>Doctors</h5>
                                            <span>List of registered Doctors</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="../index.html"><i class="ik ik-home"></i></a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="#">Tables</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Data Table</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header"><h3>Doctor's Table</h3></div>
                                    <div class="card-body">
                                        <table id="data_table" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th class="nosort">Avatar</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                    <th>Phone Number</th>
                                                    <th class="nosort">&nbsp;</th>
                                                    <th class="nosort">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            		@if(count($users)> 0)
                                            		@foreach($users as $user)
                                                <tr>
                                                    <td>{{$user->name}}</td>
                                                    <td><img src="{{ asset('images') }}/{{ $user->photo }}" class="table-user-thumb" alt=""></td>
                                                    <td>{{$user->email}}</td>
                                                    <td>{{$user->address}}</td>
                                                    <td>{{$user->phone_number}}</td>
                                                    <td>
                                                        <div class="table-actions">
                                                            <a href="#"><i class="ik ik-eye"></i></a>
                                                            <a href="#"><i class="ik ik-edit-2"></i></a>
                                                            <a href="#"><i class="ik ik-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                	@endforeach
                                                	
                                                	@else
                                                	<td> No user to display </td>
                                                	@endif
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


@endsection