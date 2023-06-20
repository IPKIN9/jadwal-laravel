import iziToast from 'izitoast'
import ErroMsg from './errormsg';

export default {
  successNotif(payload) {
    iziToast.success({
      icon: 'fas fa-check',
      title: payload.title,
      message: payload.message,
      position: 'topRight'
    })
  },

  errorNotif(code) {
    const msg = ErroMsg(code)
    iziToast.error({
      icon: 'fas fa-exclamation',
      message: msg
    });
  },
}