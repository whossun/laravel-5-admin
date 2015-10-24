/**
 * custom.js [v1.1.0]
 *
 * Editor: Hiro
 */
var loadModal = function (title, url) {
    $('#custom-modal-title').html(title);
    $('#custom-modal-body').html('');
    $('#custom-modal-body').load(url);
    $("#custom-modal").css("z-index", "1500");
    $('#custom-modal').modal();
};

var getIdCheckBox = function() {
    $('input[type=checkbox]').each(function () {
        if (this.checked) {
            id = $(this).val();
        }
    });
    return id;
};

var printer =function (elem, title)
{
    popup($(elem).html(), title);
};

var popup = function(data, title)
{
    var mywindow = window.open('', 'printer', 'width=800,height=600');
    mywindow.document.write('<html><head><title>1211111'+title+'</title>');
    mywindow.document.write('<link rel="stylesheet" href="'+URL+'/css/bootstrap.min.css" type="text/css" />');
    mywindow.document.write('<link rel="stylesheet" href="'+URL+'/css/app.css" type="text/css" />');
    mywindow.document.write('<link rel="stylesheet" href="'+URL+'/font-awesome/css/font-awesome.min.css" type="text/css" />');
    mywindow.document.write('</head><body id="printer">');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');
    mywindow.print();
    mywindow.close();
    return true;
};

var store = function(name, val) {
    if (typeof (Storage) !== "undefined") {
        localStorage.setItem(name, val);
    }
}

var get = function(name) {
    if (typeof (Storage) !== "undefined") {
        return localStorage.getItem(name);
    }
}

var check_sidebar = function() {
    $("body").addClass('sidebar-mini');
    if (get('sidebar-hide')=='true') {
        $("body").addClass('sidebar-collapse');
    }
}

var AdminLTEOptions = {
    sidebarSlimScroll: true,
    // sidebarExpandOnHover: true,
    animationSpeed: 100,
 
};

$(function() {

    $('.sidebar-toggle').click(function(e) {
        e.preventDefault();
        store('sidebar-hide', $('body').hasClass('sidebar-collapse'));
    });

    check_sidebar();

	$('#frmModel .btn-apply').click(function(e){
        e.preventDefault();
        $('input[name=task]').val('apply');
        $('#frmModel form').submit();
    });

    $('#frmModel .btn-primary').click(function(e){
        e.preventDefault();
        $('#frmModel form').submit();
    });

    $("select").each(function(index) {
        var id = $(this).attr('id');
        if (id) $('#'+id).selectize();
    });

    $.extend( true, $.fn.dataTable.defaults, {
        language: {
            "sProcessing": "处理中...",
            "sLengthMenu": "_MENU_ ",
            "sZeroRecords": "没有匹配结果",
            "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
            "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
            "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
            "sInfoPostFix": "",
            "search": "_INPUT_",
            "searchPlaceholder": "搜索",
            "sUrl": "",
            "sEmptyTable": "表中数据为空",
            "sLoadingRecords": "载入中...",
            "sInfoThousands": ",",
            "oPaginate": {
                "sFirst": "首页",
                "sPrevious": "上页",
                "sNext": "下页",
                "sLast": "末页"
            },
            "oAria": {
                "sSortAscending": ": 以升序排列此列",
                "sSortDescending": ": 以降序排列此列"
            }
        },
        dom:
            "<'row'<'col-sm-6'<'toolbar'>><'col-sm-6'<'pull-right'f><'pull-right'l>C>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        processing: true,
        serverSide: true,   
        lengthMenu: [ 10, 20, 50, 100 ],  
        pageLength: 20,  
/*        "searching": false,
        "ordering": false*/
    } );


});