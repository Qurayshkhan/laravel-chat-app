<template>
    <ul class="chat">
        <li class="left clearfix" v-for="message in messages" :key="message.id">
            <div class="clearfix">
                <div class="header">
                    <strong>
                        {{ message.user.name }}
                    </strong>
                </div>
                <p>
                    {{ message.message }}
                </p>
            </div>
        </li>
    </ul>
</template>
<script>
export default {
    props: ["messages", "group"],
    data() {
        return {
            messages: [],
            showMenu: true,
            delay: 10

        }
    },
    created() {
        this.fetchMessages();
        var self = this;
        setInterval(function(){
            self.fetchMessages();

        }, 2000);


        let len = window.Echo.private('chat')
            .listen('MessageSent', (e) => {

                this.messages.push({
                    message: e.message.message,
                    user: e.user
                });
            });


    }
    ,
    methods: {

      async  fetchMessages() {

            let url = "/messages/" + this.group.id
          await   axios.get(url).then((response) => {
                //Save the response in the messages array to display on the chat view
                this.messages = response.data;
            });

        }
        ,
    }
}
;
</script>
