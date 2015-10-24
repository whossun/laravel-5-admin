@if (session('status'))
    <script type="text/javascript">
    swal({
        title: "{{ session('status') }}.",
		text:"{{ trans('messages.autoclose') }}",
        //html: true,
        type: "{{ session('type-status', 'success') }}",
        timer: 1000,
        showConfirmButton: false
    });
    </script>
@endif