<style type="text/css">
.group:nth-of-type(odd) {
    background-color: #f9f9f9;
}
</style>
	{{$options['current']}}
	{!!Form::label('[]', $options['label'])!!}
<div class="form-group">
		@foreach ($options['tree'] as $group)
		<div class="col-xs-8 col-md-4 group">
			<ul class="list-inline">
			@foreach ($group as $val => $permissons)
				<li>
				{!!Form::checkbox('name', 'value', in_array($val,$options['selected']),$attributes=['id'=>$name.'_'.$val,'name'=>$name.'[]'])!!}
				{!!Form::label($name.'_'.$val, $permissons[0],$attributes=['class'=>'label-normal'])!!}
				</li>
			@endforeach
			</ul>
		</div>
		@endforeach
		<div class="col-md-12">有依赖的权限以<mark>D</mark>标注</div>
</div>