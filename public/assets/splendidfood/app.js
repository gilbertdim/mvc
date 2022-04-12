let app = Vue.createApp({
    delimiters: [ '[[',']]' ],
    data(){
      return {
        showSidebar: false,
        inventory: [],
        cart: {},
      }
    },
    async mounted(){ 
        const result = await fetch('/assets/splendidfood/food.json', )
        const data = await result.json()
        this.inventory = data;
    },
    computed: {
      totalQuantity(){
        const total = Object.values(this.cart).reduce((acc, item, index) => {
          return  acc + item.quantity; 
        }, 0);

        return total;
      }
    },
    methods: {
      addToCart(i, id, name) {
        if(!this.cart[name]) this.cart[name] = {
          index: i,
          id: id,
          quantity: 0
        };
        this.cart[name].quantity += this.inventory[i].quantity;
        this.inventory[i].quantity = 0;
        // this.totalQuantity += this.inventory[i].quantity;
      },
      toggleSidebar() {
        this.showSidebar = !this.showSidebar;
      },
      removeItem(index)
      {
        var item = this.cart[index];

        item.quantity -= 1;
        if(item.quantity == 0) delete this.cart[index];
      }
    }
  });

  app.component('sidebar', {
    props: [ 'toggle', 'cart', 'inventory', 'remove' ],
    computed: {
    },
    methods: {
      itemTotal(item)
      {
        return (item.quantity * this.inventory[item.index].price.USD).toFixed(2);
      },
      getIcon(icon)
      {
        return 'icofont-'+icon;
      },
      cartTotal() {
          const total = Object.values(this.cart).reduce((acc, item, index) => {
            return acc + (item.quantity * this.inventory[item.index].price.USD);
          }, 0);

        return total.toFixed(2);
      },
    },
    template: `
      <aside class="cart-container">
        <div class="cart">
          <h1 class="cart-title spread">
            <span>
              Cart
              <i class="icofont-cart-alt icofont-1x"></i>
            </span>
            <button @click="toggle" class="cart-close">&times;</button>
          </h1>

          <div class="cart-body">
            <table class="cart-table">
              <thead>
                <tr>
                  <th><span class="sr-only">Product Image</span></th>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Total</th>
                  <th><span class="sr-only">Actions</span></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, i) in cart" :key="i">
                  <td><i :class="getIcon(inventory[item.index].icon)" class="icofont-3x"></i></td>
                  <td>{{ inventory[item.index].name }}</td>
                  <td>\${{ inventory[item.index].price.USD }}</td>
                  <td class="center">{{ item.quantity }}</td>
                  <td>\${{ itemTotal(item) }}</td>
                  <td class="center">
                    <button class="btn btn-light cart-remove" @click="remove(i)">
                      &times;
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>

            <p class="center" v-if="!Object.keys(cart).length"><em>No items in cart</em></p>
            <div class="spread">
              <span><strong>Total:</strong> \${{ cartTotal() }} </span>
              <button class="btn btn-light">Checkout</button>
            </div>
          </div>
        </div>
      </aside>
    `
  })

  app.mount('#app');