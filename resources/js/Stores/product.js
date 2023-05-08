import { defineStore } from "pinia";

export const useProductStore = defineStore({
  id: "products",
  state: () => ({
    products: [],
    total: 0,
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
          this.total = 0;
          this.setProducts(data);
          data.forEach((product) => {
            this.total += (product.sku.price_incl_vat * product.amount)
           })
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
    setTotal(total) {
      this.total = total;
    },
  },
  getters: {
    getProducts() {
      return this.products;
    },
    getTotal() {
      return this.total;
    },
  },
});
