@php
    use App\Employee;
    use App\PayslipElement;
    $employee_list = Employee::get_employee_list();
    $payslip_elements = PayslipElement::get_payslip_elements();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#emp-payslip">Payslips</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="emp-payslip" class="tab-pane fade in active">
                        <div class="row padding-20">
                            <div class="col-sm-12">
                                <a href="/flakpay/hrm/payroll/ryapay-iIBwDDuu" class="btn btn-primary pull-right">Go Back</a>
                            </div>
                        </div>
                        <div class="row">
                            <div id="payslip-ajax-response" class="text-center"></div>
                            @if(!isset($form))
                            <form method="POST" class="form-horizontal" role="form" id="payslip-form">
                                <div class="form-group">
                                    <label for="input" class="col-sm-2 control-label">Employee Name:</label>
                                    <div class="col-sm-3">
                                        <select name="employee_id" id="employee_id" class="form-control">
                                            <option value="">--Select--</option>
                                                @foreach($employee_list as $employee)
                                                    <option value="{{$employee->id}}">{{$employee->full_name}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="payslip-form-elements" class="hide col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="4"><div class="col-sm-2">Employee Name:</div><span id="employee-name"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4"><div class="col-sm-2">Designation:</div><span id="employee-designation"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4">
                                                                <div class="col-sm-2">Month & Year: <span class="mandatory">*</span></div>
                                                                <div class="col-sm-2">
                                                                    <input type="text" name="payslip_month" id="payslip_month" class="form-control" value="" placeholder="DD-MM-YYYY" required="required">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2"><a href="javascript:" class="btn btn-link" onclick='addEarningRow();'>Earnings</a></th>
                                                            <th colspan="2"><a href="javascript:" class="btn btn-link" onclick='addDeductionRow();'>Deductions</a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2">
                                                                <table class="table table-bordered">
                                                                    <tbody id="emp-earnings">
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td colspan="2">
                                                                <table class="table table-bordered">
                                                                    <tbody id="emp-deductions">
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td><a href="javascript:" class="btn btn-link" onclick='calculateTotalAddition();'>Total Addition</a></td>
                                                            <td id="total-addition"></td>
                                                            <td><a href="javascript:" class="btn btn-link" onclick='calculateTotalDeduction();'>Total Deduction</a></td>
                                                            <td id="total-deduction"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan=2></td>
                                                            <td><a href="javascript:" class="btn btn-link" onclick='calculateNetSalary();'>Net Slary</a></td>
                                                            <td id="net-salary"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="total_addition" id="total_addition" value="">
                                    <input type="hidden" name="total_deduction" id="total_deduction" value="">
                                    <input type="hidden" name="net_salary" id="net_salary" value="">
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Check Number:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="check_number" id="check_number" class="form-control" value="">
                                        </div>
                                        <label for="input" class="col-sm-2 control-label">Name Of Bank:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="bank_name" id="bank_name" class="form-control" value="">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Date</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="payslip_gdate" id="payslip_gdate" class="form-control" value="" placeholder="DD-MM-YYYY" required="required">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Sinature Of Employee:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="employee_sign" id="employee_sign" class="form-control" value="">
                                        </div>
                                        <label for="input" class="col-sm-2 control-label">Director</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="director_sign" id="employee_sign" class="form-control" value="">
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary pull-right">Generate Payslip</button>
                                        </div>
                                    </div>

                                </div>
                                
                                
                            </form>
                            @else
                            <form method="POST" class="form-horizontal" role="form" id="payslip-form">
                                <div class="form-group">
                                    <label for="input" class="col-sm-2 control-label">Employee Name:</label>
                                    <div class="col-sm-3">
                                        <select name="employee_id" id="employee_id" class="form-control">
                                            <option value="">--Select--</option>
                                                @foreach($employee_list as $employee)
                                                    @if($details["employee_id"] == $employee->id)
                                                    <option value="{{$employee->id}}" selected>{{$employee->full_name}}</option>
                                                    @else
                                                    <option value="{{$employee->id}}">{{$employee->full_name}}</option>
                                                    @endif;
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="payslip-form-elements" class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="4"><div class="col-sm-2">Employee Name:</div><span id="employee-name">{{$details["full_name"]}}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4"><div class="col-sm-2">Designation:</div><span id="employee-designation">{{$details["designation"]}}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4">
                                                                <div class="col-sm-2">Month & Year: <span class="mandatory">*</span></div>
                                                                <div class="col-sm-2">
                                                                    <input type="text" name="payslip_month" id="payslip_month" class="form-control" value="{{$details['payslip_month']}}" placeholder="DD-MM-YYYY" required="required">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2"><a href="javascript:" class="btn btn-link" onclick='addEarningRow();'>Earnings</a></th>
                                                            <th colspan="2"><a href="javascript:" class="btn btn-link" onclick='addDeductionRow();'>Deductions</a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2">
                                                                <table class="table table-bordered">
                                                                    <tbody id="emp-earnings">
                                                                        @foreach($earn_deduct as $index => $earn)
                                                                            @if($earn["element_type"] == "earning")
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class='form-group'>
                                                                                            <div class="col-sm-12">
                                                                                                <select name="emp_earning[]" id="emp_earning" class="form-control">
                                                                                                    <option value=''>--Select--</option>
                                                                                                    @foreach($payslip_elements as $elements)
                                                                                                        @if($elements->id == $earn["element_id"])
                                                                                                            <option value="{{$elements->id}}" selected>{{$elements->element_label}}</option>
                                                                                                        @else
                                                                                                            <option value="{{$elements->id}}">{{$elements->element_label}}</option>
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class='col-sm-12'>
                                                                                            <input type="text" class="form-control" name="earning[]" value="{{$earn['element_value']}}">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td><i class='fa fa-times remove-earning mandatory show-pointer'></i></td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td colspan="2">
                                                                <table class="table table-bordered">
                                                                    <tbody id="emp-deductions">
                                                                        @foreach($earn_deduct as $index => $earn)
                                                                            @if($earn["element_type"] == "deduction")
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class='form-group'>
                                                                                            <div class="col-sm-12">
                                                                                                <select name="emp_deduction[]" id="emp_deduction" class="form-control">
                                                                                                    @foreach($payslip_elements as $elements)
                                                                                                        @if($elements->id == $earn["element_id"])
                                                                                                            <option value="{{$elements->id}}" selected>{{$elements->element_label}}</option>
                                                                                                        @else
                                                                                                            <option value="{{$elements->id}}">{{$elements->element_label}}</option>
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class='col-sm-12'>
                                                                                            <input type="text" class="form-control" name="deduction[]" value="{{$earn['element_value']}}">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td><i class='fa fa-times remove-deduction mandatory show-pointer'></i></td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td><a href="javascript:" class="btn btn-link" onclick='calculateTotalAddition();'>Total Addition</a></td>
                                                            <td id="total-addition">{{$details['total_addition']}}</td>
                                                            <td><a href="javascript:" class="btn btn-link" onclick='calculateTotalDeduction();'>Total Deduction</a></td>
                                                            <td id="total-deduction">{{$details['total_deduction']}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan=2></td>
                                                            <td><a href="javascript:" class="btn btn-link" onclick='calculateNetSalary();'>Net Slary</a></td>
                                                            <td id="net-salary">{{$details['net_salary']}}</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="total_addition" id="total_addition" value="{{$details['total_addition']}}">
                                    <input type="hidden" name="total_deduction" id="total_deduction" value="{{$details['total_deduction']}}">
                                    <input type="hidden" name="net_salary" id="net_salary" value="{{$details['net_salary']}}">
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Check Number:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="check_number" id="check_number" class="form-control" value="{{$details['check_number']}}">
                                        </div>
                                        <label for="input" class="col-sm-2 control-label">Name Of Bank:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="bank_name" id="bank_name" class="form-control" value="{{$details['bank_name']}}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Date</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="payslip_gdate" id="payslip_gdate" class="form-control" value="{{$details['payslip_gdate']}}" placeholder="DD-MM-YYYY" required="required">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Sinature Of Employee:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="employee_sign" id="employee_sign" class="form-control" value="{{$details['employee_sign']}}">
                                        </div>
                                        <label for="input" class="col-sm-2 control-label">Director</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="director_sign" id="employee_sign" class="form-control" value="{{$details['employee_sign']}}">
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary pull-right">Generate Payslip</button>
                                        </div>
                                    </div>

                                </div>
                                
                                
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded",function(){
        $("#payslip_month").datepicker({
            "dateFormat":"MM, yy",
            changeMonth: true,
            changeYear: true
        });
        $("#payslip_gdate").datepicker({
            "dateFormat":"dd-mm-yy",
            changeMonth: true,
            changeYear: true
        });
    });
</script>
@if(isset($form))
<script>
    document.addEventListener("DOMContentLoaded",function(){
        loadPayslipElements();
    });
</script>
@endif
