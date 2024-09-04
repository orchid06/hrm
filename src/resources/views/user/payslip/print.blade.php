@extends('layouts.master')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <section class="mt-5" id='DivIdToPrint' style="
                  width: 970px;
                  height: fit-content;
                  padding: 50px 0;
                  background: rgb(255, 255, 255);
                  margin: 0 auto;
                  box-shadow: 0 1px 2px rgba(56, 65, 74, 0.15);
                  position: relative;
                ">
                    <div style="position: absolute;right: 3%;
              bottom: 3%;">
                        <button type="button" id="btn" value="Print" onclick="printDiv();"
                            style="border: none;padding: 5px 10px;font-size: 16px;background: #182652;color: #fff;display: flex;align-items: center;border-radius: 5px;column-gap: 7px;cursor: pointer;"><i
                                class="las la-print" style="font-size: 20px;"></i>{{translate('Print')}}</button>
                    </div>
                    <div style="
                        display: flex;
                        align-items: center;
                        column-gap: 10px;
                        padding: 0 30px;
                        background: #777;
                        padding: 10px;
                  ">

                    </div>
                    <div style="
                    width: 100%;
                    height: 40px;
                    background-color: #263e6e;
                    position: relative;
                    margin: 30px 0;
                  ">
                        <div style="
                      position: absolute;
                      right: 10%;
                      top: 0;
                      background: white;
                      width: 300px;
                      height: 100%;
                      display: flex;
                      align-items: center;
                      justify-content: center;
                    ">
                            <p style="font-size: 36px; font-weight: 600; line-height:1; margin-bottom:0;">
                                {{translate('iGen Solution')}}</p>
                        </div>
                    </div>
                    <div style="
                    padding: 0 30px;
                    display: flex;
                    align-items: stretch;
                    justify-content: space-between;
                  ">
                        <div>
                            <p style="
                        font-size: 20px;
                        font-weight: 600;
                        color: #000;
                        margin: 0;
                        padding-bottom: 10px;
                      ">
                                {{translate('To')}}:
                            </p>
                            <h3 style="font-size: 18px; font-weight: 600; color: #555; margin: 0">
                                {{@$payroll->user->name }}
                            </h3>
                            <address style="
                        display: flex;
                        flex-direction: column;
                        row-gap: 5px;
                        color: #333;
                        margin-top: 5px;
                      ">
                                <span>{{translate('Designation')}} :
                                    {{@$payroll->user->userDesignation->designation->name}}</span>
                                <span>{{translate('Department')}} :
                                    {{@$payroll->user->userDesignation->designation->department->name}}</span>

                            </address>
                        </div>
                        <div>
                            <p
                                style="font-size: 15px; line-height:1; color: #555; font-weight: 500; margin: 0; width:250px; display:flex; align-items:center; justify-content:space-between;">
                                {{translate('Employee ID')}}#
                                <span style="font-size: 14px; padding-left: 30px; color: #333">
                                    {{@$payroll->user->employee_id}}
                                </span>
                            </p>

                            <p
                                style="font-size: 15px; line-height:1; color: #555; padding-top:12px; font-weight: 500; margin: 0; width:250px; display:flex; align-items:center; justify-content:space-between;">
                                {{translate('Date')}}:
                                <span style="font-size: 14px; padding-left: 30px; color: #333">
                                    {{@$payroll->created_at->format('Y-m-d')}}</span>
                            </p>


                            <p
                                style="font-size: 15px; line-height:1; color: #555; padding-top:8px; font-weight: 500; margin: 0; width:250px; display:flex; align-items:center; justify-content:space-between;">
                                {{translate('Payment Status')}}:
                                <span style="font-size: 14px; padding-left: 30px; color: #333"> {{@$payroll->status ==
                                    App\Enums\StatusEnum::true->status() ? 'Paid' : 'Unpaid'}}</span>

                            </p>
                        </div>
                    </div>




                    <div style="padding: 30px 30px 0">
                        <h1 style=" font-size: 16px;font-weight: 600;text-align: center;margin: 0;">
                            {{translate('Salary Information')}}
                        </h1>
                        <div style="overflowx-x: auto">
                            <table style="margin-top: 20px; border-collapse: collapse; width: 100%;overflow-x:auto">
                                <tr>
                                    <th style="
                                        border: 1px solid #dddddd;
                                        border-style:solid !important;
                                        text-align: center;
                                        padding: 8px;
                                        color: #535353;
                                        font-weight: 500;
                                        ">{{translate('Description')}}
                                    </th>
                                    <th style="
                                        border: 1px solid #dddddd;
                                        border-style:solid !important;
                                        text-align: center;
                                        padding: 8px;
                                        color: #535353;
                                        font-weight: 500;
                                        ">
                                        {{translate('Amount')}}
                                    </th>


                                </tr>
                                @php
                                    $basic_salary = @json_decode($payroll->details)->basic_salary->amount;
                                @endphp

                                @foreach(json_decode($payroll->details) as $detail)
                                <tr style="border: 1px solid #dddddd; border-style:solid !important;">
                                    <td style="text-align: left; padding: 8px"> {{@$detail->labels}} {{@$detail->is_percentage ? "($detail->amount %)" :""}} </td>
                                    <td style="text-align: center; padding: 8px"> {{@$detail->is_percentage ? @$basic_salary*($detail->amount/100) :@$detail->amount}} </td>

                                </tr>
                                @endforeach

                                <tr style="border: 1px solid #dddddd; border-style:solid !important;">
                                    <td style="
                                        text-align: left;
                                        padding: 8px;
                                        font-weight: 600;
                                        text-align: center;
                                        ">{{translate('Total')}} :
                                    </td>

                                    <td style="
                                        text-align: left;
                                        padding: 8px;
                                        font-weight: 600;
                                        text-align: center;
                                        ">{{@$payroll->net_pay}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 0 30px;
                    margin: 35px 0;
                  ">
                        <div style="width: 50%">
                            <div style="padding: 0 30px">
                                @php
                                $invoiceLogos = json_decode(site_settings('invoice_logo'),true)
                                @endphp


                            </div>
                        </div>

                        <div style="width: 50%;">
                            <div style="
                            display: flex;
                            flex-direction: column;
                            align-items: flex-end;
                        ">

                                <p style="
                                font-size: 14px;
                                font-weight: 500;
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                width: 250px;
                                padding-right: 10px;
                                margin: 0;
                                color: #555;
                            ">
                                    {{translate('Signature')}} :
                                    <small style="padding-left: 30px; color: #333; font-size: 14px"></small>
                                </p>


                            </div>
                        </div>
                    </div>


                    <div style="position: absolute;right: 3%;
              bottom: 3%;">
                        <button type="button" id="btn" value="Print" onclick="printDiv();"
                            style="border: none;padding: 5px 10px;font-size: 16px;background: #182652;color: #fff;display: flex;align-items: center;border-radius: 5px;column-gap: 7px;cursor: pointer;"><i
                                class="las la-print" style="font-size: 20px;"></i>{{translate('Print')}}</button>
                    </div>
                    <div style="
                        display: flex;
                        align-items: center;
                        column-gap: 10px;
                        padding: 0 30px;
                        background: #777;
                        padding: 10px;
                  ">

                    </div>
                    <div style="
                    width: 100%;
                    height: 40px;
                    background-color: #263e6e;
                    position: relative;
                    margin: 30px 0;
                  ">
                        <div style="
                      position: absolute;
                      right: 10%;
                      top: 0;
                      background: white;
                      width: 300px;
                      height: 100%;
                      display: flex;
                      align-items: center;
                      justify-content: center;
                    ">
                            <p style="font-size: 36px; font-weight: 600; line-height:1; margin-bottom:0;">
                                {{translate('iGen Solution')}}</p>
                        </div>
                    </div>
                    <div style="
                    padding: 0 30px;
                    display: flex;
                    align-items: stretch;
                    justify-content: space-between;
                  ">
                        <div>
                            <p style="
                        font-size: 20px;
                        font-weight: 600;
                        color: #000;
                        margin: 0;
                        padding-bottom: 10px;
                      ">
                                {{translate('To')}}:
                            </p>
                            <h3 style="font-size: 18px; font-weight: 600; color: #555; margin: 0">
                                {{@$payroll->user->name }}
                            </h3>
                            <address style="
                        display: flex;
                        flex-direction: column;
                        row-gap: 5px;
                        color: #333;
                        margin-top: 5px;
                      ">
                                <span>{{translate('Designation')}} :
                                    {{@$payroll->user->userDesignation->designation->name}}</span>
                                <span>{{translate('Department')}} :
                                    {{@$payroll->user->userDesignation->designation->department->name}}</span>

                            </address>
                        </div>
                        <div>
                            <p
                                style="font-size: 15px; line-height:1; color: #555; font-weight: 500; margin: 0; width:250px; display:flex; align-items:center; justify-content:space-between;">
                                {{translate('Employee ID')}}#
                                <span style="font-size: 14px; padding-left: 30px; color: #333">
                                    {{@$payroll->user->employee_id}}
                                </span>
                            </p>

                            <p
                                style="font-size: 15px; line-height:1; color: #555; padding-top:12px; font-weight: 500; margin: 0; width:250px; display:flex; align-items:center; justify-content:space-between;">
                                {{translate('Date')}}:
                                <span style="font-size: 14px; padding-left: 30px; color: #333">
                                    {{@$payroll->created_at->format('Y-m-d')}}</span>
                            </p>


                            <p
                                style="font-size: 15px; line-height:1; color: #555; padding-top:8px; font-weight: 500; margin: 0; width:250px; display:flex; align-items:center; justify-content:space-between;">
                                {{translate('Payment Status')}}:
                                <span style="font-size: 14px; padding-left: 30px; color: #333"> {{@$payroll->status ==
                                    App\Enums\StatusEnum::true->status() ? 'Paid' : 'Unpaid'}}</span>

                            </p>
                        </div>
                    </div>




                    <div style="padding: 30px 30px 0">
                        <h1 style=" font-size: 16px;font-weight: 600;text-align: center;margin: 0;">
                            {{translate('Salary Information')}}
                        </h1>
                        <div style="overflowx-x: auto">
                            <table style="margin-top: 20px; border-collapse: collapse; width: 100%;overflow-x:auto">
                                <tr>
                                    <th style="
                                        border: 1px solid #dddddd;
                                        border-style:solid !important;
                                        text-align: center;
                                        padding: 8px;
                                        color: #535353;
                                        font-weight: 500;
                                        ">{{translate('Description')}}
                                    </th>
                                    <th style="
                                        border: 1px solid #dddddd;
                                        border-style:solid !important;
                                        text-align: center;
                                        padding: 8px;
                                        color: #535353;
                                        font-weight: 500;
                                        ">
                                        {{translate('Amount')}}
                                    </th>


                                </tr>
                                @php
                                    $basic_salary = @json_decode($payroll->details)->basic_salary->amount;
                                @endphp

                                @foreach(json_decode($payroll->details) as $detail)
                                <tr style="border: 1px solid #dddddd; border-style:solid !important;">
                                    <td style="text-align: left; padding: 8px"> {{@$detail->labels}} {{@$detail->is_percentage ? "($detail->amount %)" :""}} </td>
                                    <td style="text-align: center; padding: 8px"> {{@$detail->is_percentage ? @$basic_salary*($detail->amount/100) :@$detail->amount}} </td>

                                </tr>
                                @endforeach

                                <tr style="border: 1px solid #dddddd; border-style:solid !important;">
                                    <td style="
                                        text-align: left;
                                        padding: 8px;
                                        font-weight: 600;
                                        text-align: center;
                                        ">{{translate('Total')}} :
                                    </td>

                                    <td style="
                                        text-align: left;
                                        padding: 8px;
                                        font-weight: 600;
                                        text-align: center;
                                        ">{{@$payroll->net_pay}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 0 30px;
                    margin: 35px 0;
                  ">
                        <div style="width: 50%">
                            <div style="padding: 0 30px">
                                @php
                                $invoiceLogos = json_decode(site_settings('invoice_logo'),true)
                                @endphp


                            </div>
                        </div>

                        <div style="width: 50%;">
                            <div style="
                            display: flex;
                            flex-direction: column;
                            align-items: flex-end;
                        ">

                                <p style="
                                font-size: 14px;
                                font-weight: 500;
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                width: 250px;
                                padding-right: 10px;
                                margin: 0;
                                color: #555;
                            ">
                                    {{translate('Employee Signature')}} :
                                    <small style="padding-left: 30px; color: #333; font-size: 14px"></small>
                                </p>


                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')



@endsection

@push('script-push')
<script>

    function printDiv() {
        var divToPrint = document.getElementById('DivIdToPrint');
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
        newWin.document.close();
    }



</script>
@endpush
