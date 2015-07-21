import 'whatwg-fetch';

const API_ROOT = 'http://shoppinglist/api/v1/';

function status(response) {
  if(response.status >= 200 && response.status < 300){
    return response;
  }
  throw new Error(response.statusText);
}

function call(url, params = {}) {
  if(url.indexOf(API_ROOT) === -1){
    url = API_ROOT + url;
  }
  return fetch(url, params)
    .then(status);
}

export default {
  login(email, password) {
    let data = new FormData();
    data.append('email', email);
    data.append('password', password);
    return call('user/login', {
      method: 'post',
      body: data
    });
  }
};
