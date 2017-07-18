import Auth from "../components/user/Auth";
const baseUrl = 'http://localhost:5000';

const getOptions = () => ({
  mode: 'cors',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  }
});

const  handleJsonResponse = res => res.json();

const applayAuthHeader = (options,authenticated) => {
  if (authenticated) {
    let token = Auth.getToken();
    options.headers.Authorization = `bearer ${token}`
  }
};

class Data {
  static get (url,authenticated){
    let options = getOptions();
    applayAuthHeader(options,authenticated);

    return window.fetch(`${baseUrl}${url}`, options)
      .then(handleJsonResponse);
  }
  static post (url,data,authenticated) {
    let options = getOptions();
    options.method = 'POST';
    options.body = JSON.stringify(data);
    applayAuthHeader(options,authenticated);
    return window.fetch(`${baseUrl}${url}`, options)
      .then(handleJsonResponse);
  }
}

export default Data;