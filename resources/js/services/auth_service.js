import { http, httpFile } from './http_service';
import store from '../store';
// import jwt from 'jsonwebtoken';

export function login(data) {
  return http()
    .post('/auth/login', data)
    .then(res => {
      setToken(res.data);
      store.dispatch('user/getUser').then(() => {
        location.reload();
      });
    });
}

export function logout() {
  return new Promise(resolve => {
    http()
      .post('/auth/logout')
      .then(res => {
        store.dispatch('user/removeUser');
        resolve(res);
      });
  });
}

function setToken(data) {
  localStorage.setItem('token', data);
}

export function getAccessToken() {
  const token = localStorage.getItem('token');
  return token;
}

export function updateImage(id, data) {
  httpFile().post(`/member/update-image/${id}`, data);
}

export function updateUserImage(id, data) {
  httpFile().post(`/user/update-image/${id}`, data);
}
