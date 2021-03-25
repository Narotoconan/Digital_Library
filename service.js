import axios from "axios";

const service = axios.create({
  baseURL: "http://digital_library.com/",
  timeout: 6 * 1000,
  withCredentials: true
});
service.defaults.withCredentials = true;
service.defaults.headers.post["Content-Type"] =
    "application/json;charset=utf-8";

const errorHandle = (status, other) => {
  switch (status) {
    case 400:
      //信息效验失败
      break;
    case 401:
      //登录验证
      break;
    case 403:
      //token过时 登录
      break;
    case 404:
      //请求的资源不存在
      break;
    default:
  }
};

service.interceptors.request.use(
  function(config) {
    // Do something before request is sent
    if (config.method === "post") {
      //config.data = qs.stringify(config.data);
      //console.log(config.data);
    }
    return config;
  },
  function(error) {
    // Do something with request error
    return Promise.reject(error);
  }
);

service.interceptors.response.use(
  response => {
    return response.status === 200
      ? Promise.resolve(response)
      : Promise.reject(response);
  },
  error => {
    const { response } = error;
    if (response) {
      errorHandle(response.status, response.data.message);
      return Promise.reject(response);
    } else {
      console.log("Net Work Error");
    }
  }
);

export default service;
