import { defineStore } from "pinia";

export const useWishlistStore = defineStore({
  id: "wishlist",
  state: () => ({
    count: 0,
  }),
  actions: {
    setCount(counter) {
      this.count = counter;
    },
    fetchCount() {
      fetch("/wishlist/count")
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
  },
  getters: {
    getCount(state) {
      return state.count;
    },
  },
});
