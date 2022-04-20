// mutation types
export const GET_DISCIPLINES = "getDisciplines";
export const SET_DISCIPLINES = "setDisciplines";

export const store = {
  state: {
    disciplines: [],
  },
  getters: {
    disciplines(state) {
      return state.disciplines
    },
  },
  mutations: {
    [SET_DISCIPLINES](state, disciplines) {
      state.disciplines = disciplines
    },
  }
}

export default store
