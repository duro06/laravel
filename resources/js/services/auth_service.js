import { http } from './http_service';
import store from '../store';
// import jwt from 'jsonwebtoken';

export function login(data) {
  return http()
    .post('/auth/login', data)
    .then(res => {
      setToken(res.data);
      store.dispatch('user/getUser');
      console.log(res);
    });
}

export function logout() {
  return http()
    .post('/auth/logout')
    .then(res => {
      store.dispatch('user/removeUser');
      console.log(res);
    });
}

function setToken(data) {
  localStorage.setItem('token', data);
}

export function getAccessToken() {
  const token = localStorage.getItem('token');
  return token;
}

// export function getUser(){
//   http().get('/user')
// }
