import 'whatwg-fetch';

// TODO put this into a config file
const API_ROOT = 'http://localhost:3001/v1/';

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
    .then(status)
    .then((response) => {
      return response.json();
    })
    .catch(() => {
      throw new Error('The response was not JSON.');
    });
}

export default {
  googleLogin(token) {
    let data = new FormData();
    data.append('idToken', token);
    return call('user/google-login', {
      method: 'post',
      body: data
    });
  }
};
