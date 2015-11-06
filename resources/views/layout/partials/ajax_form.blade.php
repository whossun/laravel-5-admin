<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">{{($route['action']== 'index') ? trans('messages.'.$route['table']) : trans('messages.'.$route['action']).trans('messages.'.$route['table'])}}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!!form($form)!!}
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <div class="form-group">
            <div class="text-right">
                <button class="btn btn-default pull-left" onclick="bootbox.hideAll()"><i class="fa fa-times fa-fw"></i>{{ trans('messages.cancel') }}</button>
                <button class="btn btn-primary" onclick="ajaxSubmit()"><i class="fa fa-floppy-o fa-fw"></i>{{ trans('messages.save') }}</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
});
function ajaxSubmit(){
    var frm = $('.bootbox-body').find('form');
    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        cache: false,
        dataType: 'json',
        success: function(data) {
            if($('#dt-table').length > 0) {
                toastr.options.onShown = function() {  $('#dt-table').DataTable().ajax.reload( null, false );}
            }else{
                toastr.options.onHidden = function() { window.location.reload(); }
            }
            bootbox.hideAll();
            toastr[data.type](data.status);
        }
    });
}
</script>