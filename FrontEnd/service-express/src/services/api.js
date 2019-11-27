import axios from "axios";

const api = axios.create({
  baseURL: "http://localhost:3030/serviceexpress"
});

export default api;
