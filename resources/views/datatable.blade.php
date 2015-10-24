@extends('layout.partials.datatable')

@section('table')
    <table class="table table-striped table-condensed table-hover" id="dt-table"></table>
@stop

@section('scripts')
<script type="text/javascript">
$(document).ready(function (){
    var rows_selected = [];
    var table = $('#dt-table').DataTable({
        stateSave: true,
        ajax: '',
        order: [1, 'desc'],
        columns: {!! $html !!},
        drawCallback: function( settings ) {
            // $('div.dataTables_filter input').addClass('input[type=search]');
            $('.btn-remove,.btn-delete ').click(function(e) {
                    e.preventDefault();
                    deleteDataTableSelect($(this));
                    return false;
            });
            var api = this.api();
            var info = api.page.info()
            if(info.page == info.pages && info.pages!=0){
                var table = this.DataTable();
                table.page('last').draw(false);
                window.location.reload();
            }
        }
    });

    $('div.toolbar').append($('div.toolbars').contents());

    $('.btn-new').click(function(e) {
        e.preventDefault();
        window.location.href = '{{ url(Request::path()) }}/create';
    });

    $('.btn-edit').click(function(e) {
        e.preventDefault();
        var id = getIdCheckBox();
        window.location.href = '{{ url(Request::path()) }}/'+id+'/edit';
    });

    function checkDeleteTitle(tr){//判断删除框取哪个td的标题
        var firstTd = tr.find("td:first").children().first().prop('nodeName');
        if(firstTd == "INPUT"){
            title = "<mark>"+tr.find("td:eq(2)").html()+"</mark>";
        }else{
            title = "<mark>"+tr.find("td:eq(1)").html()+"</mark>";
        }
        return title;
    }

    function deleteDataTableSelect(button){//判断来源哪个删除按钮
        var title = "{{ trans('messages.delete.confirm')}}";
        if (typeof button.data("id") === "undefined") {//remove button
            var checkedValues = $('tbody input:checkbox:checked').map(function() {
                return this.value;
            }).get();
            var count = $('tbody input:checkbox:checked').length;
            if(count>1){
                title += "<mark>"+count+"条</mark>";
                title += "{{trans('messages.'.$route['table'])}}";
            }else{
                title += "{{trans('messages.'.$route['table'])}}";
                title += checkDeleteTitle($('tbody input:checkbox:checked').parent().parent());
            }
        }else{//single button
            var checkedValues = button.data("id");
            title += "{{trans('messages.'.$route['table'])}}";
            title += checkDeleteTitle(button.parent().parent());
        }
        swal({
            title: title+"？",
            text:"{{ trans('messages.delete.message') }}",
            html: true,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: "{{ trans('messages.yes') }}",
            cancelButtonText:  "{{ trans('messages.no') }}",
            closeOnConfirm: false
        },
        function(){
            var frm = $('#frmList');
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action')+'/'+checkedValues,
                data: frm.serialize(),
                cache: false,
                dataType: 'json',
                success: function(data) {
                    swal({
                        title: "{{ trans('messages.delete.success') }}!",
                        text: "{{ trans('messages.autoclose') }}!",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    $('#dt-table').DataTable().ajax.reload( null, false ); // user paging is not reset on reload
                },
                error: function(xhr, textStatus, thrownError) {
                    var title = "AJAX request error.\n";
                    switch (textStatus) {
                        case 'timeout':
                            message = "The request timed out.";
                            break;
                        case 'notmodified':
                            message = "The request was not modified but was not retrieved from the cache.";
                            break;
                        case 'parsererror':
                            message = "XML/Json format is bad.";
                            break;
                        default:
                            message = "HTTP Error (" + xhr.status + " " + xhr.statusText + ").";
                    }
                    swal(title, message, "error");
                }
            });
        });
    }


    @if (str_contains($html, 'select_all'))
    //http://www.gyrocode.com/articles/jquery-datatables-checkboxes/
    function updateDataTableSelectAllCtrl(table){
       var $table             = table.table().node();
       var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
       var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
       var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);
       $('.btn-remove').removeClass('hide');
       // If none of the checkboxes are checked
       if($chkbox_checked.length === 0){
            $('.btn-remove').addClass('hide');
            chkbox_select_all.checked = false;
            if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = false;
            }
       // If all of the checkboxes are checked
        } else if ($chkbox_checked.length === $chkbox_all.length){
            chkbox_select_all.checked = true;
            if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = false;
            }
       // If some of the checkboxes are checked
       } else {
            chkbox_select_all.checked = true;
            if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = true;
            }
        }
    }

    // Handle click on checkbox
    $('#dt-table tbody').on('click', 'input[type="checkbox"]', function(e){
        var $row = $(this).closest('tr');
        // Get row data
        var data = table.row($row).data();
        // Get row ID
        var rowId = data[0];
        // Determine whether row ID is in the list of selected row IDs
        var index = $.inArray(rowId, rows_selected);
        // If checkbox is checked and row ID is not in list of selected row IDs
        if(this.checked && index === -1){
            rows_selected.push(rowId);
        // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index !== -1){
            rows_selected.splice(index, 1);
        }

        if(this.checked){
            $row.addClass('selected');
        } else {
            $row.removeClass('selected');
        }
        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(table);
        // Prevent click event from propagating to parent
        e.stopPropagation();
    });

   // Handle click on table cells with checkboxes
/*   $('#dt-table').on('click', 'tbody td, thead th:first-child', function(e){
      $(this).parent().find('input[type="checkbox"]').trigger('click');
   });*/

   // Handle click on "Select all" control
    $('#dt-table thead input[name="select_all"]').on('click', function(e){
        if(this.checked){
            $('#dt-table tbody input[type="checkbox"]:not(:checked)').trigger('click');
        } else {
            $('#dt-table tbody input[type="checkbox"]:checked').trigger('click');
        }
        // Prevent click event from propagating to parent
        e.stopPropagation();
    });

   // Handle table draw event
    table.on('draw', function(){
        // Update state of "Select all" control
        if ( $('#dt-table thead input[name="select_all"]').length ){
            updateDataTableSelectAllCtrl(table);
        }
    });
    @endif



});
</script>
@stop