import {createApp} from 'vue';
require('./bootstrap');
const el = document.getElementById('app')
const app = createApp({
     //Store chat messages for display in this array.
    props: ["group"],
     data() {
        return {
         messages: [],
         groupID: '',
        }
    },
    //Upon initialisation, run fetchMessages().
    created() {

        let len = window.Echo.private('chat')
        .listen('MessageSent', (e) => {

            this.messages.push({
            message: e.message.message,
            user: e.user
            });
        });

    },
    methods: {
        // fetchMessages() {
        //     axios.get("/messages").then((response) => {
        //         //Save the response in the messages array to display on the chat view
        //         this.messages = response.data;
        //     });
        // },
        //Receives the message that was emitted from the ChatForm Vue component
        addMessage(message) {
            //Pushes it to the messages array

            this.messages.push(message);
            //POST request to the messages route with the message data in order for our Laravel server to broadcast it.
            axios.post("/messages/"+message.group.id, message).then((response) => {

            });
        },
    }
})
//resources/js/app.js
app.component('example-component', require('./components/ExampleComponent.vue').default);
//Add these two components.
app.component('chat-messages', require('./components/ChatMessages.vue').default);
app.component('chat-form', require('./components/ChatForm.vue').default);
app.mount(el)
