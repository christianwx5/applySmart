<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel with Vue</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <h3 v-for="datum in apiData" :key="datum.id">
            @{{ `${datum.id} ${datum.title}` }} 
        </h3>
    </div>

    <!-- Vue y Axios -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3.2.26"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.23.0"></script>
    
    <!-- Tu componente Vue -->
    <script>
        const App = Vue.createApp({
            
            data() {
                return {
                    apiData: [],
                    datum: {}
                };
            },
            mounted() {
                this.fetchData();
            },
            methods: {
                async fetchData() {
                    try {
                        const response = await axios.get('/JobOffers');
                        this.apiData = response.data;
                        console.log(this.apiData);
                    } catch (error) {
                        console.error('Error fetching data:', error);
                    }
                },
            },
        });
        const vm = App.mount('#app');
        console.log(vm);
    </script>

    <style scoped>
    /* Tus estilos aquí */
    </style>
</body>
</html>
