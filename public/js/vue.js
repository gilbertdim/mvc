let app = Vue.createApp({
    // delimiters: ['${', '}'],
    data: function(){
        return {
            greeting: 'Hello Vue!',
            isVisibleRed : false,
            isVisibleBlue : true,
            isVisibleYellow : false,
        }
    },
    methods: {
        toggleBlue: function(){
            this.isVisibleBlue = !this.isVisibleBlue;
        },
        toggleYellow() {
            this.isVisibleYellow = !this.isVisibleYellow;
        },
        greet(name) {
            console.log(this.greeting+' '+name);
        }
    }
});

app.component('login-form', {
    template: `
        <form @submit.prevent="handleSubmit" class="w-52 mx-auto">
            <h1 class="text-xl font-bold">{{ title }}</h1>
            <custom-input 
                v-for="(input, i) in inputs"
                :key="i"
                v-model="input.value" 
                v-bind:label="input.label"
                v-bind:type="input.type"
            />
            <button class="border-2 border-gray-700 text-white hover:bg-white hover:text-gray-800 bg-gray-800 rounded-md w-full mt-2">Log in</button>
        </form>
    `,
    components: ['custom-input'],
    data() {
        return {
            title: 'Login Form',
            inputs: [
                {
                    label: 'Email',
                    value: '',
                    type: 'email'
                },
                {
                    label: 'Password',
                    value: '',
                    type: 'password'
                }
            ],
            email: '',
            password: '',
            emailLabel: 'Email',
            passwordLabel: 'Password',
        }
    },
    methods: {
        handleSubmit()
        {
            console.log(this.inputs[0].value, this.inputs[1].value);
        }
    }
});

app.component('custom-input', {
    template: `
        <label>
            {{ label }}
            <input :type="type" v-model="inputValue" class="w-full rounded-md block px-2 py-0 border-2 border-black" />
        </label>
    `,
    props: [ 'label', 'type', 'modelValue' ],
    computed: {
        inputValue: {
            get(){
                return this.modelValue;
            },
            set(value){
                this.$emit('update:modelValue', value);
            }
        }
    }
    // data(){
    //     return {
    //         inputValue: ''
    //     }
    // }
});

app.mount('#app')