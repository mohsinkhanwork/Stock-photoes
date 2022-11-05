<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Episode 1: The Absolute Basics</title>
    <script src="https://unpkg.com/vue@3"></script>
</head>
<body>
    <div id="app">
        <p>
            <input type="text" v-model="greeting">
        </p>

        <p>
            {{ greeting }} {{ greeting.length }}
        </p>
    </div>

    <script src="http://cdnjs.cloudflare.com/ajax/libs/vue/1.0.1/vue.min.js"></script>

    <script>
        Vue.createApp({
            data() {
                return {
                    greeting: 'What is up'
                };
            },

            mounted() {
                setTimeout(() => {
                    this.greeting = 'Changed';
                }, 3000);
            }
        }).mount('#app');
    </script>
</body>
</html>
