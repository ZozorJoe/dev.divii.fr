export const SET_SUCCESS = "setSuccess";
export const SET_ERROR = "setError";
export const SET_ERRORS = "setErrors";
export const ADD_ERROR = "addError";
export const SET_LOADING = "setLoading";

export const store = {
  state: {
    loading: false,
    errors: [],
    error: null,
    success: null,
  },
  getters: {
    errors: (state) => (field) => {
      return state.errors[field] ? state.errors[field] : [];
    },
    error(state)  {
      return state.error;
    },
    success(state) {
      return state.success;
    },
    isLoading(state) {
      return state.loading;
    },
  },
  mutations: {
    [SET_LOADING](state, value) {
      state.loading = value
    },
    [SET_ERRORS](state, errors) {
      state.errors = errors ?? []
    },
    [ADD_ERROR](state, { name, errors }) {
      state.errors[name] = errors
    },
    [SET_ERROR](state, error) {
      state.error = error
    },
    [SET_SUCCESS](state, success) {
      state.success = success
    },
  }
}

export default store
