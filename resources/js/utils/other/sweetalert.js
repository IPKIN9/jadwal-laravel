import Swal from 'sweetalert2'
export default {
  confirmNotif(callback) {
    Swal.fire({
      title: 'Hapus data ini?',
      text: "Data ini tidak dapat dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        callback()
      }
    })
  },

  confirmLogout(callback) {
    Swal.fire({
      title: 'Logout?',
      text: "Anda akan ke halaman login!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Logout',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        callback()
      }
    })
  }
}