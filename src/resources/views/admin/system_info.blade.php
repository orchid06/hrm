@extends('admin.layouts.master')
@section('content')

	<div class="container-fluid px-0">
		<div class="i-card-md">
			<div class="card-body">
				<ol class="list-group list-group-numbered">
					<li class="list-group-item d-flex justify-content-between align-items-start">
						<div class="ms-2 me-auto">
							{{translate('Document Root Folder')}}
						</div>
						<span>{{$systemInfo['server_detail']['DOCUMENT_ROOT']}}</span>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-start">
						<div class="ms-2 me-auto">
							{{translate('System Laravel Version')}}
						</div>
						<span>{{$systemInfo['laravel_version']}}</span>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-start">
						<div class="ms-2 me-auto">
							{{translate("PHP Version")}}
						</div>
						<span>{{$systemInfo['php_version']}}</span>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-start">
						<div class="ms-2 me-auto">
							{{translate('IP Address')}}
						</div>
						<span>{{$systemInfo['server_detail']['REMOTE_ADDR']}}</span>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-start">
						<div class="ms-2 me-auto">
							{{translate('System Server host')}}
						</div>
						<span>{{$systemInfo['server_detail']['HTTP_HOST']}}</span>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-start">
						<div class="ms-2 me-auto">
							{{translate('Database Port Number')}}
						</div>
						<span>{{$systemInfo['server_detail']['DB_PORT']}}</span>
					</li>
				</ol>
			</div>
		</div>
	</div>

@endsection
