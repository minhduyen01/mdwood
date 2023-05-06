export default {
  namespaced: true,
  state() {
    return {
      breadCrumbs: null,
      listCart: JSON.parse(localStorage.getItem("listCart")) || []
    };
  },
  mutations: {
    setState(state, data) {
      for (const propertyName in state) {
        if (data[propertyName]) {
          state[propertyName] = data[propertyName];
        }
      }
    }
  },
  actions: {
    setListCart({ commit }, payload) {
      commit("setState", { listCart: payload });
      localStorage.setItem("listCart", JSON.stringify(payload));
    }
  }
};
