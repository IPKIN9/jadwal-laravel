import axios from 'axios'

export default (url) => {
  return axios.create({
    baseURL: url,
    withCredentials: true,
    headers: {
      common: {
        'Accept': 'application/json',
      },
    }
  })
}