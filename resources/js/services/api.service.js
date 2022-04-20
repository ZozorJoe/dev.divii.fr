import {SET_ERROR, SET_ERRORS, SET_SUCCESS} from "./store/form.module";

/**
 * Service to call HTTP request via Axios
 */
const ApiService = {
  uri: '/api/v1',

  /**
   * Set the default HTTP request headers
   */
  setHeader() {
    // Nothing
  },

  /**
   * Send the GET HTTP request
   * @param resource
   * @param params
   * @returns {*}
   */
  get(resource, params) {
    return axios.get(this.uri + resource, params)
  },

  /**
   * Set the POST HTTP request
   * @param resource
   * @param params
   * @returns {*}
   */
  post(resource, params) {
    return axios.post(this.uri + resource, params)
  },

  /**
   * Set the PUT HTTP request
   * @param resource
   * @param params
   * @returns {*}
   */
  put(resource, params) {
    return axios.put(this.uri + resource, params)
  },

  list(resource, params, item, callback, store, t) {
    const request = axios.get(this.uri + resource, params)
    request.then((response) => {
        store.commit(SET_ERRORS, {})
        if(response.data.success) {
          callback(response.data.data)
        }else{
          store.commit(SET_ERROR, t('messages.error'));
        }
      })
    request.catch((error) => {
        console.error('error', error)
        const response = error.response
        if(response && response.data && response.data.message){
          store.commit(SET_ERROR, response.data.message);
        }else{
          store.commit(SET_ERROR, t('messages.error'));
        }
        if(response && response.data && response.data.errors){
          store.commit(SET_ERRORS, response.data.errors);
        }
      })
    return request
  },
  show(resource, params, item, callback, store, t) {
    const request = axios.get(this.uri + resource, params)
    request.then((response) => {
        store.commit(SET_ERRORS, {})
        if(response.data.success) {
          callback(response.data.data)
        }else{
          store.commit(SET_ERROR, t('messages.error'));
        }
      })
    request.catch((error) => {
        console.error('error', error)
        const response = error.response
        if(response && response.data && response.data.message){
          store.commit(SET_ERROR, response.data.message);
        }else{
          store.commit(SET_ERROR, t('messages.error'));
        }
        if(response && response.data && response.data.errors){
          store.commit(SET_ERRORS, response.data.errors);
        }
      })
    return request
  },
  store(resource, params, item, callback, store, t) {
    const request = axios.post(this.uri + resource, params)
    request.then((response) => {
        store.commit(SET_ERRORS, {})
        if(response.data.success) {
          if(callback) {
            callback()
          }
          store.commit(SET_SUCCESS, t('messages.item.created',{item: item}));
        }else{
          store.commit(SET_ERROR, t('messages.error'));
        }
      })
    request.catch((error) => {
        console.error('error', error)
        const response = error.response
        if(response && response.data && response.data.message){
          store.commit(SET_ERROR, response.data.message);
        }else{
          store.commit(SET_ERROR, t('messages.error'));
        }
        if(response && response.data && response.data.errors){
          store.commit(SET_ERRORS, response.data.errors);
        }
      })
    return request
  },
  update(resource, params, item, callback, store, t) {
    store.commit(SET_ERRORS, {})
    const request = axios.put(this.uri + resource, params)
    request.then((response) => {
        if(response.data.success) {
          if(callback){
            callback(response.data.data)
          }
          store.commit(SET_SUCCESS, t('messages.item.updated',{item: item}));
        }else{
          store.commit(SET_ERROR, t('messages.error'));
        }
      })

    request.catch((error) => {
        console.error('error', error)
        const response = error.response
        if(response && response.data && response.data.message){
          store.commit(SET_ERROR, response.data.message);
        }else{
          store.commit(SET_ERROR, t('messages.error'));
        }
        if(response && response.data && response.data.errors){
          store.commit(SET_ERRORS, response.data.errors);
        }
      })

    return request
  },
  delete(resource, params) {
    return axios.delete(this.uri + resource, params)
  }
};

export default ApiService;
