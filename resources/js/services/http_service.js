import Axios from 'axios'
import store from '../store'

export function http(){
 return Axios.create({
  baseURL:store.getters['auth/apiUrl'],
 })
}