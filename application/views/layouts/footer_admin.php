</div>
    </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Yakin untuk Keluar?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Pilih "Keluar" di bawah jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
        <div class="modal-footer">
          <button class="btn btn-outline-warning" type="button" data-dismiss="modal"><i class="fas fa-fw fa-times mr-1"></i>Cancel</button>
          <a class="btn btn-danger" href="<?= site_url('Login/Logout'); ?>"><i class="fas fa-fw fa-sign-out-alt mr-1"></i>Logout</a>
        </div>
      </div>
    </div>
  </div>

  <script src="<?= base_url('assets/')?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets/')?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <script src="<?= base_url('assets/')?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <script src="<?= base_url('assets/')?>js/sb-admin-2.min.js"></script>

  <script src="<?= base_url('assets/')?>vendor/chart.js/Chart.min.js"></script>
  
  <script src="<?= base_url('assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <script src="<?= base_url('assets/')?>js/demo/datatables-demo.js"></script>
  
  <script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });

  // Script untuk menghilangkan alert otomatis dalam 3 detik
  window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove(); 
      });
  }, 2000);
  </script>

</body>

</html>