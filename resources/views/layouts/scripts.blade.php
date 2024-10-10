 <!-- container-scroller -->


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
 {{-- Select2 --}}
 <script src="{{ asset('assets/vendors/select2-bootstrap-5/select2-bs5.min.js') }}"></script>

 {{-- DataTables --}}
 <script src="{{ asset('assets/vendors/datatables/download/datatables.min.js') }}"></script>
 <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.bootstrap5.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.colVis.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
 <script src="https://cdn.datatables.net/colreorder/2.0.4/js/dataTables.colReorder.min.js"></script>
 <script src="https://cdn.datatables.net/colreorder/2.0.4/js/colReorder.bootstrap5.min.js"></script>
 <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.min.js"></script>
 <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/rowReorder.bootstrap5.min.js"></script>


 {{-- Tooltip --}}
 <script>
     $(function() {
         $('[data-toggle="tooltip"]').tooltip()
     })
 </script>
 @yield('scripts')
