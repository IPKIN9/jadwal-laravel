import CryptoJS from "crypto-js";

export default {
  checkToken() {
    let token = localStorage.getItem('users')
    return token
  },
  
  createJwtToken(payload) {
    try {
      const secretKey = process.env.VUE_APP_API_KEY;
    
      let tokenScript = CryptoJS.AES.encrypt(payload, secretKey).toString()

      return tokenScript
    } catch (error) {
      return error
    }
  }
}