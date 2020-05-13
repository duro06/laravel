import { http } from './http_service';
export function login(data) {
  console.log(data);
  return http()
    .post('auth/login', data)
    .then(res => {
      console.log(res);
    });
}
