
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#merchant-document-list">Document List</a></li>  
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-primary btn-sm pull-right margin-bottom-lg" href="{{route('merchant-document','ryapay-7WRwwggm')}}" role="button">Go Back</a>
                        </div>
                    </div>
                    <div id="merchant-document-list" class="tab-pane fade in active">
                        @php($table_count=0)
                        <div class="table-responsive" id="">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Document Name</th>
                                        <th>Document File</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                                <tbody id="bginfotable">
                                    @if(count($extmdocs)>0)
                                        @foreach($extmdocs as $extmdoc)
                                        <tr> 
                                            <td>{{++$table_count}}</td>
                                            <td>{{$extmdoc->doc_name}}</td>
                                            <td><a href="{{route('download-extra-doc',$extmdoc->doc_file)}}">{{$extmdoc->doc_name}}</a> </td>
                                            <td>{{$extmdoc->created_date}}</td>
                                        </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="4">No Data found</td>
                                    </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                            <div class="col-sm-6">
                                <h5 class="pagination">Showing {{$extmdocs->firstItem()==''?'0':$extmdocs->firstItem()}} to {{$extmdocs->lastItem() =='' ? '0':$extmdocs->lastItem()}} of {{$extmdocs->total()}} entries</h5> 
                            </div>
                            <div class="col-sm-6 text-right">
                                <ul class="pagination">
                                    <li><a href="{{$extmdocs->previousPageUrl()}}">Previous</a></li>
                                    <li><a href="javascript:">{{$extmdocs->currentPage()}}</a></li>
                                    <li><a href="{{$extmdocs->nextPageUrl()}}">Next</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
