@php
    use App\Employee;
    $employee_list = Employee::get_employee_list();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                            <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li> 
                        @else
                        <li><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li>
                        @endif
                    @endforeach
                    @else
                        <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#{{str_replace(' ','-',strtolower($sublink_name))}}">{{$sublink_name}}</a></li> 
                    @endif
                    <li><a data-toggle="tab" class="show-pointer" data-target="#add-edit-agreement">Add/Edit Agreement</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @if(count($sublinks) > 0)
                        @foreach($sublinks as $index => $value)
                            @if($index == 0)
                            <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Docment</th>
                                                    <th>Employee</th>
                                                    <th>Uploaded Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ca_docs as $ca_doc)
                                                <tr>
                                                    <td><a href="/storage/rupayapay/documents/ca/{{$ca_doc->employee_docs}}">CA Document</a></td>
                                                    <td>{{$ca_doc->full_name}}</td>
                                                    <td>{{$ca_doc->created_date}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="add-edit-agreement" class="tab-pane fade">
                                <div class="row padding-20">
                                    <div id="ajax-response-message" class="text-center col-sm-4 col-sm-offset-1"></div>
                               </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <form id="ca-form" class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-2">Select Employee:</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control" name="employeeconalist" id="employeeconalist">
                                                                <option value="">--Select--</option>
                                                                @foreach($employee_list as $employee)
                                                                    <option value="{{$employee->id}}">{{$employee->full_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="form-element">
                                                            
                                                    </div>
                                                    {{csrf_field()}}
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            
                            </div>
                            @endif
                        @endforeach

                    @else
                        <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Docment</th>
                                                <th>Employee</th>
                                                <th>Uploaded Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ca_docs as $ca_doc)
                                            <tr>
                                                <td><a href="/storage/rupayapay/documents/ca/{{$ca_doc->employee_docs}}">CA Document</a></td>
                                                <td>{{$ca_doc->full_name}}</td>
                                                <td>{{$ca_doc->created_date}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="add-edit-agreement" class="tab-pane fade">
                            <div class="row padding-20">
                                <div id="ajax-response-message" class="text-center col-sm-4 col-sm-offset-1"></div>
                           </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form id="ca-form" class="form-horizontal">
                                                <div class="form-group">
                                                    <label for="" class="col-sm-2">Select Employee:</label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control" name="employeeconalist" id="employeeconalist">
                                                            <option value="">--Select--</option>
                                                            @foreach($employee_list as $employee)
                                                                <option value="{{$employee->id}}">{{$employee->full_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="form-element">
                                                        
                                                </div>
                                                {{csrf_field()}}
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
