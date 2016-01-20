<div class="row">
	<div class="col-xs-6">
		@if(empty($request->uploads))
		<h4>No Uploads</h4>
		@else
		<ul class="list-group" id="uploadDiv">
			<li class="list-group-item text-center"><h4>Current Uploaded Files</h4></li>
			@foreach($request->uploads as $file)

			<li class="list-group-item" id="file-{!! $file->id !!}">
				<a href="/download/{!! $file->id !!}/direct" title="Download File"><span class="badge"><i class="fa fa-download"></i></span></a>
                @if($request->Status->name != 'Approved')
				    <a href="#" data-fileid="{!! $file->id !!}" title="Delete File" class="delete-file"><span class="badge"><i class="fa fa-trash-o"></i></span></a>
                @endif
                <a class="pdf cboxElement" href="/download/{!! $file->id !!}" title="View File">{!! str_limit($file->file_name, $limit = 35, $end = '...') !!}</a>
			</li>
			@endforeach
		</ul>
		@endif
	</div>
	@if($request->Status->name != 'Approved')
	<div class="col-xs-6">
		<div class="form-group">
			<div id="myDrop" class="dropzone">
				<div class="dz-default dz-message">
					<span><i class="fa fa-cloud-upload fa-3x"></i><br>File Upload</span>
				</div>
			</div>
		</div>
	</div>
	@else
	<div class="col-xs-6">
		<div class="form-group">
			<h4>No files may be added</h4>
		</div>
	</div>
	@endif
</div>