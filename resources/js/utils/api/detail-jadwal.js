import server from './main'

const baseUrl = process.env.VUE_APP_API_URL
const endPoint= "api/v1/detail/"

export default {
  getAll(params) {
    return server(baseUrl).get(
      `${endPoint}jadwal/?kelas_id=${params.kelas_id}&start_date=${params.start_date}&end_date=${params.end_date}`
    )
  },

  scaningJadwal(params) {
    return server(baseUrl).get(
      `${endPoint}scanning?kelas_id=${params.kelas_id}&guru_id=${params.guru_id}&tgl=${params.tgl}&jam_masuk=${params.jam_masuk}&jam_keluar=${params.jam_keluar}`
    )
  },

  getById(id) {
    return server(baseUrl).get(`${endPoint}jadwal/${id}`)
  },

  delete(id) {
    return server(baseUrl).delete(`${endPoint}jadwal/${id}`);
  }
}