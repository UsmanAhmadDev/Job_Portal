@extends('frontend.layouts.app')

@section('main')
    <section class="section-4 bg-2">    
        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('jobs') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                        </ol>
                    </nav>
                </div>
            </div> 
        </div>
        <div class="container job_details_area">
            <div class="row pb-5">
                <div class="col-md-8">
                    @include('frontend.message')
                    <div class="card shadow border-0">
                        <div class="job_details_header">
                            <div class="single_jobs white-bg d-flex justify-content-between">
                                <div class="jobs_left d-flex align-items-center">
                                    
                                    <div class="jobs_conetent">
                                        <a href="#">
                                            <h4>{{ $job->title }}</h4>
                                        </a>
                                        <div class="links_locat d-flex align-items-center">
                                            <div class="location">
                                                <p> <i style="padding-right: 6px" class="fa fa-map-marker"></i>{{ $job->location }}</p>
                                            </div>
                                            <div class="location">
                                                <p> <i style="padding-right: 6px" class="fa fa-clock-o"></i>{{ $job->jobType->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="jobs_right">
                                    <div class="apply_now {{ ($count == 1) ? 'saved-job' : '' }}">
                                        <a class="heart_mark" href="javascript:void(0);" onclick="saveJob({{ $job->id }})"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="descript_wrap white-bg">
                            <div class="single_wrap">
                                <h4>Job description</h4>
                                {!! nl2br($job->description) !!}
                            </div>
                                @if (!empty($job->responsibility))
                                    <div class="single_wrap">
                                        <h4>Responsibility</h4>
                                        {!! nl2br($job->responsibility) !!}
                                    </div>
                                @endif
                                @if (!empty($job->qualification))
                                    <div class="single_wrap">
                                        <h4>Qualifications</h4>
                                        {!! nl2br($job->qualification) !!}
                                    </div>
                                @endif
                                @if (!empty($job->benefits))
                                    <div class="single_wrap">
                                        <h4>Benefits</h4>
                                        {!! nl2br($job->benefits) !!}
                                    </div>
                                @endif
                            <div class="border-bottom"></div>
                            <div class="pt-3 text-end">
                                @if (Auth::check())
                                    <a href="javascript:void(0)" onclick="saveJob({{ $job->id }});" class="btn btn-secondary">Save</a>
                                @else
                                    <a href="javascript:void()" class="btn btn-secondary disabled">Login to Save</a>
                                @endif
                                @if (Auth::check())
                                    <a href="javascript:void(0)" onclick="applyJob({{ $job->id }})" class="btn btn-primary">Apply</a>
                                @else
                                    <a href="javascript:void()" class="btn btn-primary disabled">Login to Apply</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if (Auth::user())
                        @if (Auth::user()->id == $job->user_id)
                            <div class="card shadow border-0 mt-4">
                                <div class="job_details_header">
                                    <div class="single_jobs white-bg d-flex justify-content-between">
                                        <div class="jobs_left d-flex align-items-center">
                                            <div class="jobs_conetent">
                                                <h4>Applicants</h4>
                                            </div>
                                        </div>
                                        <div class="jobs_right"></div>
                                    </div>
                                </div>
                                <div class="descript_wrap white-bg">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Applied Date</th>
                                        </tr>
                                        @if ($applications->isNotEmpty())
                                            @foreach ($applications as $application)
                                                <tr>
                                                    <td>{{ $application->user->name }}</td>
                                                    <td>{{ $application->user->email }}</td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td colspan="3">Applicants not found.</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Job Summery</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Published on: <span>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</span></li>
                                    <li>Vacancy: <span>{{ $job->vacancy }}</span></li>
                                    @if (!empty($job->salary))
                                        <li>Salary: <span>{{ $job->salary }}</span></li>
                                    @endif
                                    <li>Location: <span>{{ $job->location }}</span></li>
                                    <li>Job Nature: <span>{{ $job->jobType->name }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow border-0 my-4">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Company Details</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Name: <span>{{ $job->company_name }}</span></li>
                                    @if (!empty($job->company_location))
                                        <li>Location: <span>{{ $job->company_location }}</span></li>
                                    @endif
                                    @if (!empty($job->company_website))
                                        <li>Webite: <span><a href="{{ $job->company_website }}">{{ $job->company_website }}</a></span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('customjs')
    <script type="text/javascript">
        // function applyJob(id){
        //     if (confirm("Are you sure you want to apply on this job")) {
        //         $.ajax({
        //             url : '{{ route("applyJob") }}',
        //             type: 'post',
        //             data: {id:id},
        //             dataType: 'json',
        //             success: function(response){
        //                 window.location.href="{{ url()->current() }}";
        //             }
        //         });
        //     }
        // }

        function applyJob(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to undo this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, apply!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : '{{ route("applyJob") }}',
                        type: 'post',
                        data: {id:id},
                        dataType: 'json',
                        success: function(response){
                            window.location.href="{{ url()->current() }}";
                        }
                    });
                }
            });
        }


        function saveJob(id){
            $.ajax({
                url : '{{ route("saveJob") }}',
                type: 'post',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    window.location.href="{{ url()->current() }}";
                }
            });
        }
    </script>
@endsection