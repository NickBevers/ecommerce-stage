import { defineStore } from "pinia";

export const useProductStore = defineStore({
  id: "products",
  state: () => ({
    products: [],
  }),
  actions: {
    setProducts(products) {
      this.products = products;
    },
    fetchProducts() {
      fetch("/cart/products")
        .then((response) => {
          return response.json();
        })
        .then((data) => {
          this.setProducts(data);
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
  },
  getters: {
    getProducts() {
      return this.products;
    },
  },
});
