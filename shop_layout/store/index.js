import Vue from "vue";
import Vuex from "vuex";
import cart from "./modules/cart";


Vue.use(Vuex);
const store = () => {
  return new Vuex.Store({
    modules: {
      cart,
    },
    strict: process.env.NODE_ENV !== "production"
  });
};
export default store;
