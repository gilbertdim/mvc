let app = Vue.createApp({
    delimiters: ['${', '}'],
    data(){
    return {
        inventory: {
            carrots: 0,
            pineapples: 0,
            cherries: 0
        },
        cart: {
        carrots: 0,
        pineapples: 0,
        cherries: 0
        }
    }
    },
    methods: {
    addToCart(type){
        this.cart[type] += this.inventory[type];
    }
    }
});

app.mount('#app');
