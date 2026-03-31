@if (session('status'))
    <script>
        var toastHtml = '<i class="material-icons">check</i> {{session('status')}}';

        M.toast({html: toastHtml,
        classes: "green rounded"});
    </script>
@endif
@if (session('error'))
    <script>
        M.toast({html: @json(session('error')), classes: "red rounded"});
    </script>
@endif
