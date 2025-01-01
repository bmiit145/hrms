@extends('team_head.team_head_layout.sidebar')
@section('content')

{{-- fa fa icon sacript  --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

{{-- mobile flage and country code selected script --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    
    .employee{
        border-radius: 13px 5px;
        background: #696cff;
        color: white;
        border: none;
        margin-left: 95%;
        height: 38px;
        width: 4%;
        position: relative;
        margin-bottom: 10px;
    }
    .editmodel{
        width: 200%;
        margin-left: -45%;
    }
    .iti{
        width: 100%;
    }
    html:not(.layout-footer-fixed) .content-wrapper {
        padding-bottom: 520px !important;
    }

    @media (max-width: 767px) {
        .employee {
            margin-left: 41%; /* Adjust the margin for smaller screens */
            width: 13%; /* Make the button full width */
        }
        .editmodel{
            width: 100%;
            margin-left: 0%;
        }
    }
</style>
<h4 style="color: black">Employee</h4>
<div class="card">
    <a  href="{{route('admin.employee.create')}}">
        <button class="employee"><i class="fa fa-plus" aria-hidden="true"></i></button></a>
    <div class="table-responsive text-nowrap">
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Employee Name</th>
                    <th>Employee MobileNo.</th>
                    <th>Employee Email</th>
                    <th>Employee Joining Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{$item->emo_name}}</td>
                    <td>{{$item->emp_mobile_no}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{ \Carbon\Carbon::parse($item->joining_date )->format('d-m-y') }}</td>
                    <td>                    
                        <a href="{{route('teamHead.teamHead_employee_view',$item->id)}}" class="view">
                            <i class="fa fa-eye" style="font-size:24px;color:gray"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Include jQuery and DataTables JS and CSS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


<script type="text/javascript">
$(document).ready(function() {
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
  

    $(document).ready(function () {
        $('#example').DataTable();
    });
    
});
</script>
@endsection
