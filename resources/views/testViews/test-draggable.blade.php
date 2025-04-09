<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue Draggable Demo</title>
    <style> 
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        .col-6 {
            width: 48%;
        }

        .dragArea {
            border: 1px solid #ccc;
            padding: 10px;
            min-height: 200px;
            background-color: #f9f9f9;
        }

        .drag-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 5px;
            background-color: #fff;
            cursor: move;
            position: relative;
        }

        .drag-item button {
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
        }

        h3 {
            margin-bottom: 10px;
        }

        button {
            padding: 10px 20px;
            margin-bottom: 20px;
            cursor: pointer;
            margin-right: 10px;
        }

        /* Añadimos las transiciones */
        .drag-item-move {
            transition: transform 0.2s;
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="row">
            <div class="col-6">
                <h3>Lista 1</h3>
                <button @click="addToList1">Añadir Elemento</button>
                <button @click="removeAllFromList1">Eliminar Todos</button>
                <draggable class="dragArea" :list="list1" group="items" :clone="clone" :move="checkMove" @start="start" :animation="200">
                    <template #item="{ element, index }">
                        <transition-group name="list" tag="div" class="drag-container">
                            <div class="drag-item" :key="element.id">
                                @{{ element.name }}
                                <button @click="removeFromList1(index)">x</button>
                            </div>
                        </transition-group>
                    </template>
                </draggable>
            </div>
            <div class="col-6">
                <h3>Lista 2</h3>
                <button @click="addToList2">Añadir Elemento</button>
                <button @click="removeAllFromList2">Eliminar Todos</button>
                <draggable class="dragArea" :list="list2" group="items" :animation="200">
                    <template #item="{ element, index }">
                        <transition-group name="list" tag="div" class="drag-container">
                            <div class="drag-item" :key="element.id">
                                @{{ element.name }}
                                <button @click="removeFromList2(index)">x</button>
                            </div>
                        </transition-group>
                    </template>
                </draggable>
            </div>
        </div>
    </div>

    <!-- Vue y Draggable -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3.2.26"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuedraggable@4.0.0"></script>
    <script>
        let idCounter = 7; // Para generar nuevos IDs
        const App = {
            data() {
                return {
                    list1: [
                        { name: 'Item 1', id: 1 },
                        { name: 'Item 2', id: 2 },
                        { name: 'Item 3', id: 3 }
                    ],
                    list2: [
                        { name: 'Item A', id: 4 },
                        { name: 'Item B', id: 5 },
                        { name: 'Item C', id: 6 }
                    ],
                    controlOnStart: false
                };
            },
            methods: {
                clone({ name }) {
                    return { name, id: idCounter++ };
                },
                checkMove(evt) {
                    return !evt.draggedContext.element.name.startsWith('Item A');
                },
                start(evt) {
                    this.controlOnStart = evt.originalEvent.ctrlKey;
                },
                addToList1() {
                    this.list1.push({ name: `Nuevo Item ${idCounter}`, id: idCounter++ });
                },
                removeFromList1(index) {
                    this.list1.splice(index, 1);
                },
                removeAllFromList1() {
                    this.list1 = [];
                },
                addToList2() {
                    this.list2.push({ name: `Nuevo Item ${idCounter}`, id: idCounter++ });
                },
                removeFromList2(index) {
                    this.list2.splice(index, 1);
                },
                removeAllFromList2() {
                    this.list2 = [];
                }
            }
        };

        Vue.createApp(App).component('draggable', vuedraggable).mount('#app');
    </script>
</body>
</html>
