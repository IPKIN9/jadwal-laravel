import server from './main'

const baseUrl = "http://127.0.0.1:8000"
const endPoint= "api/v1/jurusan/"

export default {
  getAll(params) {
    return server(baseUrl).get(
      `${endPoint}?search=${params.search}&limit=${params.limit}&page=${params.page}&orderBy=${params.orderBy}&sort=${params.sort}`
    )
  },

  upsert(payload) {
    return server(baseUrl).post(endPoint, payload)
  },

  getById(id) {
    return server(baseUrl).get(`${endPoint}${id}`)
  },

  delete(id) {
    return server(baseUrl).delete(`${endPoint}${id}`);
  }
}