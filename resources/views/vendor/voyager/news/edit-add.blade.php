@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.(!is_null($dataTypeContent->getKey()) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.(!is_null($dataTypeContent->getKey()) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
  <div class="page-content edit-add container-fluid">
    <form role="form"
      class="form-edit-add"
      action="@if(!is_null($dataTypeContent->getKey())){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
      method="POST" enctype="multipart/form-data">
      <!-- PUT Method if we are editing -->
      @if(!is_null($dataTypeContent->getKey()))
          {{ method_field("PUT") }}
      @endif
      
      <!-- CSRF TOKEN -->
      {{ csrf_field() }}
            
      <div class="row">
        <div class="col-md-8">
          <!-- Title -->            
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">
                <span class="panel-desc">Title</span>
              </h3>
              <div class="panel-actions">
                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
              </div>
            </div>
            <div class="panel-body">
              <div class="form-group">
                <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="@if(isset($dataTypeContent->title)){{ $dataTypeContent->title }}@endif"/>
              </div>
              <div class="form-group">
                  <label for="slug">Slug</label>
                  <input type="text" class="form-control" id="slug" name="slug"
                      placeholder="slug"
                      {{!! isFieldSlugAutoGenerator($dataType, $dataTypeContent, "slug") !!}}
                      value="@if(isset($dataTypeContent->slug)){{ $dataTypeContent->slug }}@endif">
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Post Content</h3>
            </div>
              <div class="panel-body">
                  @if (count($errors) > 0)
                    <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif

                  @php
                      $dataTypeRows = $dataType->{(!is_null($dataTypeContent->getKey()) ? 'editRows' : 'addRows' )};
                      $exclude = ['title', 'slug', 'published_date', 'created_at', 'meta_title', 'meta_description'];
                  @endphp

                  @foreach($dataTypeRows as $row)
                      @if(!in_array($row->field, $exclude))
                          <!-- GET THE DISPLAY OPTIONS -->
                          @php
                              $options = json_decode($row->details);
                              $display_options = isset($options->display) ? $options->display : NULL;
                          @endphp
                          @if ($options && isset($options->legend) && isset($options->legend->text))
                              <legend class="text-{{$options->legend->align or 'center'}}" style="background-color: {{$options->legend->bgcolor or '#f0f0f0'}};padding: 5px;">{{$options->legend->text}}</legend>
                          @endif
                          @if ($options && isset($options->formfields_custom))
                              @include('voyager::formfields.custom.' . $options->formfields_custom)
                          @else
                              <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width or 12 }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                  {{ $row->slugify }}
                                  <label for="name">{{ $row->display_name }}</label>
                                  @include('voyager::multilingual.input-hidden-bread-edit-add')
                                  @if($row->type == 'relationship')
                                      @include('voyager::formfields.relationship')
                                  @else
                                      {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                  @endif

                                  @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                      {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                  @endforeach
                              </div>
                          @endif
                      @endif
                  @endforeach

              </div><!-- panel-body -->

              <div class="panel-footer">
                  <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
              </div>
              
          </div>
        </div>
        <div class="col-md-4">
          <!-- General Item Settings -->
          <div class="panel panel panel-bordered panel-warning">
            <div class="panel-heading">
              <h3 class="panel-title">News Settings</h3>
              <div class="panel-actions"><a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a></div>
            </div>
            <div class="panel-body">
              <div class="form-group">
                <label for="published_date">Published Date</label>
                <input type="datetime" class="form-control date_picker" id="published_date" name="published_date" placeholder="Published Date" value="@if(isset($dataTypeContent->published_date)){{ $dataTypeContent->published_date }}@endif" />
              </div>
              <div class="form-group">
                <label for="created_at">Created At</label>
                <input type="datetime" class="form-control date_picker" id="created_at" name="created_at" placeholder="Created At" value="@if(isset($dataTypeContent->created_at)){{ $dataTypeContent->created_at }}@endif" />
              </div>
              <div class="form-group">
                <label for="status">Status</label>
                
              </div>
            </div>
          </div>
          <!-- Meta Data Settings -->
          <div class="panel panel-bordered panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Meta Data</h3>
              <div class="panel-actions"><a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a></div>
            </div>
            <div class="panel-body">
              <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Meta Title" value="@if(isset($dataTypeContent->meta_title)){{ $dataTypeContent->meta_title }}@endif" />
              </div>
              <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <textarea name="meta_description" id="meta_description" rows="10" class="form-control">
                    @if(isset($dataTypeContent->meta_description)){{ $dataTypeContent->meta_description }}@endif
                </textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>

    <iframe id="form_target" name="form_target" style="display:none"></iframe>
    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
        <input name="image" id="upload_file" type="file"
                  onchange="$('#my_form').submit();this.value='';">
        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        {{ csrf_field() }}
    </form>
  </div>

  <div class="modal fade modal-danger" id="confirm_delete_modal">
      <div class="modal-dialog">
          <div class="modal-content">

              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"
                          aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
              </div>

              <div class="modal-body">
                  <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                  <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}
                  </button>
              </div>
          </div>
      </div>
  </div>
  <!-- End Delete File Modal -->
@stop

@section('javascript')
    <script>
        var params = {}
        var $image

        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.type != 'date' || elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', function (e) {
                e.preventDefault();
                $image = $(this).siblings('img');

                params = {
                    slug:   '{{ $dataType->slug }}',
                    image:  $image.data('image'),
                    id:     $image.data('id'),
                    field:  $image.parent().data('field-name'),
                    _token: '{{ csrf_token() }}'
                }

                $('.confirm_delete_name').text($image.data('image'));
                $('#confirm_delete_modal').modal('show');
            });

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $image.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing image.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
