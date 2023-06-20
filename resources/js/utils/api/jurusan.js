import axios from 'axios'
import server from './main'

const baseUrl = process.env.APP_URL
const endPoint= "api/v1/jurusan/"

export default {
  getAll(params) {
    return server(baseUrl).get(
      `${endPoint}?search=${params.search}&limit=${params.limit}&page=${params.page}&orderBy=${params.orderBy}&sort=${params.sort}`
    )
  },

  upsert(payload) {
    return axios.post(payload)
  },

  getById(id) {
    return server(baseUrl).get(`${endPoint}${id}`)
  },

  delete(id) {
    return server(baseUrl).delete(`${endPoint}${id}`);
  }
}