export default (code) => {
  let msg
  switch (code) {
    case 404:
      msg = {
        title: 'Not Found',
        message: 'Alamat api tidak ditemukan'
      }
    break;
    case 422:
      msg = {
        title: 'Input Tidak Sesuai',
        message: 'Periksa kembali data yang dikirim'
      }
    break;
    case 500:
      msg = {
        title: 'Pemeliharaan Server',
        message: 'Mohon maaf, terjadi kesalahan internal pada server'
      }
      break;
    case 403:
      msg = {
        title: 'Akses Tidak Diizinkan',
        message: 'Maaf, Anda tidak memiliki izin untuk mengakses halaman ini'
      }
      break;
    case 400:
      msg = {
        title: 'Kesalahan Inputan',
        message: 'Maaf, permintaan yang Anda kirimkan tidak dapat diproses karena adanya kesalahan'
      }
      break;
    case 401:
      msg = {
        title: 'Akses Dibatasi',
        message: 'Maaf, Anda tidak memiliki otorisasi untuk mengakses halaman ini'
      }
      break;
    case 409:
      msg = {
        title: 'Jadwal Konflik',
        message: 'Maaf, Data yang anda masukan telah memiliki jadwal dikelas lain'
      }
      break;
    case 503:
      msg = {
        title: 'Peningkatan Layanan',
        message: 'Mohon maaf, layanan tidak tersedia saat ini'
      }
      break;
  
    default:
      msg = {
        title: 'Masalah Lainnya',
        message: 'Hubungi administrator untuk mengatasi masalah ini'
      }
      break;
  }

  return msg
}