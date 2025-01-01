@extends('admin_layout.sidebar')
@section('content')

{{-- fa fa icon sacript  --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
<style>
     html:not(.layout-footer-fixed) .content-wrapper {
        padding-bottom: 431px !important;
    }
</style>

<h4 style="color: black">Attendance Sheet</h4>
<div class="card">
    <div class="table-responsive text-nowrap">
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>First In</th>
                    <th>Break</th>
                    <th>Last Out</th>
                    <th>Working Hour</th>
                    <th>Attendance Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{$item->user_name}}</td>
                    <td>{{$item->de_name}}</td>
                    <td>{{$item->first_in}}</td>
                    <td>1:00 to 2:00 PM</td>
                    <td>{{ $item->last_out}}</td>
                    <td>
                        @if($item->last_out)
                            <?php
                                $workingHours = \Carbon\Carbon::parse($item->last_out)->diffInHours(\Carbon\Carbon::parse($item->first_in));
                                $workingMinutes = \Carbon\Carbon::parse($item->last_out)->diffInMinutes(\Carbon\Carbon::parse($item->first_in)) % 60;
                                
                                // Subtract 1 hour for break
                                if ($workingHours > 0) {
                                    $workingHours -= 1;
                                } else {
                                    $workingHours = 0;
                                }
                            ?>
                            <span style="color: {{ $workingHours >= 8 ? '#798899' : 'red' }}">
                                {{ $workingHours }} hours {{ $workingMinutes }} minutes
                            </span>
                        @else
                            ''
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->today_date)->format('d-m-y') }}</td>
                    <td> @if($item->status == 0)
                        <div>Absent</div>
                        @else
                        <div>Present</div>
                        @endif
                    </td> 
                    <td><a class="edit" href="#" data-id='{{$item->id}}' data-first_in='{{$item->first_in}}' data-today_date='{{$item->today_date}}'
                           data-last_out='{{$item->last_out}}' data-status='{{$item->status}}' data-emp_id = '{{$item->emp_id}}'>
                         <i class="fa fa-edit" style="font-size:24px;color:#36a50b"></i>
                        </a>
                        <a href="#" class="delete" data-id='{{$item->id}}'>
                            <i class="fa fa-trash-o" style="font-size:24px;color:red"></i>
                        </a>
                       
                    </td>
                </tr>
                @endforeach
              --}}
               
            </tbody>
        </table>
    </div>
</div>
     
@endsection
