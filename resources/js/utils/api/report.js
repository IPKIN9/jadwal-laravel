import server from './main'

const baseUrl = process.env.VUE_APP_API_URL
const endPoint= "api/v1/report/"

export default {
  getAll(params) {
    return server(baseUrl).get(
      `${endPoint}jadwal?jurusan_id=${params.jurusan_id}&limit=${params.limit}&page=${params.page}&orderBy=${params.orderBy}&sort=${params.sort}&start=${params.start}&end=${params.end}`
    )
  }
}