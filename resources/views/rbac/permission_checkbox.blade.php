<div class="form-group">
	{{print_r($options['tree'])}}
	{{$options['current']}}
	{!!Form::label('[]', $options['label'])!!}
	<div class="row">
		@foreach ($options['choices'] as $val=>$option)
		<div class="col-md-3">
			{!!Form::label($name.'_'.$val, $option,$attributes=['class'=>'label-normal'])!!}
			{!!Form::checkbox('name', 'value', in_array($val,$options['selected']),$attributes=['id'=>$name.'_'.$val,'name'=>$name.'[]'])!!}
		</div>
		@endforeach
		<div class="col-md-12">有依赖的权限以<mark>D</mark>标注</div>
	</div>
</div>

@section('scripts')
<script>
$(document).ready(function(){
	$('input').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
	});
});
</script>
@stop