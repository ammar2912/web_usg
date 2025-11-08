<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
      <a class="nav-link collapsed" href="/dashboard">
        <i class="bi bi-grid"></i>
        <span>Beranda</span>
      </a>
    </li>
    
    <li class="nav-item">
      <a class="nav-link collapsed" href="/sheep">
        <i class="bi bi-journals"></i>
        <span>Data Domba</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/user">
        <i class="bi bi-person"></i>
        <span>Tim Rekam Medik</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/list-penyakit">
        <i class="bi bi-clipboard-plus"></i>
        <span>Asessmen Awal</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/vital-sign">
        <i class="bi bi-clipboard-check"></i>
        <span>Vital Sign</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/radiologi">
        <i class="bi bi-file-easel"></i>
        <span>USG</span>
      </a>
    </li>  

  <li class="nav-item">
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <button type="button" id="logout-btn" class="nav-link collapsed" style="background: none; border: none; color: inherit; cursor: pointer;">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span>Keluar</span>
    </button>
</li>

</ul>

</aside><!-- End Sidebar-->

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var currentUrl = window.location.pathname;
    var sidebarLinks = document.querySelectorAll('#sidebar-nav .nav-link');
    
    sidebarLinks.forEach(function(link) {
      if (link.getAttribute('href') === currentUrl) {
        link.classList.add('active');
        link.classList.remove('collapsed');
      }
    });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("logout-btn").addEventListener("click", function () {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Anda akan keluar dari akun!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Keluar",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("logout-form").submit();
            }
        });
    });
</script>