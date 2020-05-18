import Axios from 'axios';
import store from '../store';
import * as auth from './auth_service';

// Axios.defaults.withCredentials = true;

export function http() {
  return Axios.create({
    baseURL: store.getters['auth/apiUrl'],
    headers: {
      Authorization: 'Bearer ' + auth.getAccessToken()
    }
  });
}
export function httpFile() {
  return Axios.create({
    baseURL: store.getters['auth/apiUrl'],
    headers: {
      Authorization: 'Bearer ' + auth.getAccessToken(),
      'Content-Type': 'multipart/form-data'
    }
  });
}
