@if (session('success'))
<script type="text/javascript">
  $(document).ready(function(){
  Swal.fire({
  position: "center",
  icon: 'success',
  title: "{{ session('success') }}",
  showConfirmButton: true,
  timer: 6000
})
});
</script>
@endif


@if (session('error'))
<script type="text/javascript">
  $(document).ready(function(){
    Swal.fire({
     position: "center",
     icon: 'error',
     type: "error",
     title: "{{ session('error') }}",
     showConfirmButton: true,
     timer: 6000,
   })
});
</script>
@endif