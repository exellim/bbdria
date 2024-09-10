 <!-- container-scroller -->

 {{-- Select2 --}}
 <script src="{{ asset('assets/vendors/select2-bootstrap-5/select2-bs5.min.js') }}"></script>
 <!-- endinject -->
 <!-- Plugin js for this page -->
 {{-- <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script> --}}
 <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
 <!-- End plugin js for this page -->
 <!-- inject:js -->
 <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
 <script src="{{ asset('assets/js/misc.js') }}"></script>
 {{-- <script src="{{ asset('assets/js/settings.js') }}"></script> --}}
 <script src="{{ asset('assets/js/todolist.js') }}"></script>
 <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
 <!-- endinject -->

 <!-- Custom js for this page -->
 <script src="{{ asset('assets/js/dashboard.js') }}"></script>
 <!-- End custom js for this page -->

 <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
 <!-- End plugin js for this page -->
 <!-- inject:js -->
 <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
 {{-- SWAL 2 --}}
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


 <!-- Hover -->
 <script src="{{ asset('assets/old/js/hoverable.js') }}"></script>
 {{-- Tooltip --}}
 <script>
     $(function() {
         $('[data-toggle="tooltip"]').tooltip()
     })
 </script>
 @yield('scripts')
