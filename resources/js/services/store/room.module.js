// mutation types
export const SET_ROOM = "setRoom";

export const store = {
  state: {
    room: null,
  },
  getters: {
    currentRoom(state) {
      return state.room
    },
  },
  mutations: {
    [SET_ROOM](state, room) {
      state.room = room
    },
  }
}

export default store
