
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        <?php if(session('error')): ?>
        toastr.error("<?php echo e(session('error')); ?>", 'Error', {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-bottom-right"
        });
    <?php endif; ?>
    });
</script>


<?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/generalSettings/toastermsgDemo.blade.php ENDPATH**/ ?>