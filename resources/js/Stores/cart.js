import { defineStore } from "pinia";

export const useCartStore = defineStore({
  id: "cart",
  state: () => ({
    count: 0,
    open: false,
  }),
  actions: {
    setCount(counter) {
      this.count = counter;
    },
    fetchCount() {
      fetch("/cart/count")
        .then((response) => {
          return response.json();
        })
        .then((data) => {
          this.setCount(data.count);
        });
    },
    increment() {
      this.count++;
    },
    decrement() {
      this.count--;
    },
    setIncrement(counter) {
      this.count = this.count + counter;
    },
    setOpen(open) {
      this.open = open;
    },
  },
  getters: {
    getCount(state) {
      return state.count;
    },
    getOpen(state) {
      return state.open;
    },
  },
});
